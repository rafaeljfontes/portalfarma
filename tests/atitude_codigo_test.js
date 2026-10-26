const assert = require('node:assert/strict');
const fs = require('node:fs');
const vm = require('node:vm');
const path = require('node:path');
const script = fs.readFileSync(path.join(__dirname, '../assets/js/atitude-votacao.js'), 'utf8');
async function executar(cenario, limite = 3) {
    const handlers = {}, requests = [], mensagens = [], modais = [];
    const opcoes = Array.from({length: 4}, (_, i) => {
        const card = { notas: Array.from({length: 5}, (_, n) => ({ name: `notas[${i+1}][${['relevancia','impacto','pessoas','duracao','beneficios'][n]}]`, value: '4' })), fieldsets: Array.from({length:5}, () => ({})), avaliacao: {} };
        card.querySelector = () => card.avaliacao;
        card.querySelectorAll = s => s === 'fieldset' ? card.fieldsets : card.notas;
        return { value: String(i+1), checked: i < limite, disabled: false, card, closest: () => card, matches: s => s === '.atitude-voto-checkbox' };
    });
    if (cenario === 'incompleto') opcoes[1].card.notas.pop();
    if (cenario === 'poucos') opcoes[0].checked = false;
    const botao = {}, contador = {}, ajuda = {}, csrf = {name:'csrf', value:'original'};
    const email = {value:'pessoa@example.com', validity:{valid: cenario !== 'email'}, reportValidity(){return this.validity.valid;}, addEventListener(n, fn){handlers['email-'+n]=fn;}};
    const lista = {querySelectorAll: () => opcoes, addEventListener(n, fn){handlers['lista-'+n]=fn;}};
    const form = {dataset:{limite:String(limite),codigoUrl:'solicitar_codigo'}, action:'votar', elements:{token:{value:'token'}}, addEventListener(n,fn){handlers[n]=fn;}};
    
    const Swal = {
        isLoading: () => false,
        showValidationMessage: texto => mensagens.push(texto),
        fire: async options => {
            modais.push(options);
            if (options.title === 'Confirme sua avaliação') {
                assert(opcoes.filter(p=>p.checked).every(p=>p.disabled && p.card.fieldsets.every(f=>f.disabled)), 'Seleção e notas congeladas');
                assert.equal(options.input, undefined, 'Não solicita código ou novo campo de e-mail');
                if(cenario === 'cancelar')return {isDismissed:true};
                let data = await options.preConfirm();
                if(cenario === 'tentar-novamente' && data === false)data = await options.preConfirm();
                return data === false ? {isDismissed:true} : {isConfirmed:true,value:data};
            }
            return {};
        }
    };
    const ids = {'atitude-votacao-form':form,'atitude-projetos-publicos':lista,'atitude-votar-botao':botao,'atitude-voto-email':email,'atitude-votos-contador':contador,'atitude-votos-ajuda':ajuda,'atitude-voto-csrf':csrf};
    vm.runInNewContext(script, {document:{getElementById:id=>ids[id]}, Swal, URLSearchParams, fetch: async(url,options)=>{
        requests.push({url,body:options.body});
        const fail = ['falha-envio','ip-duplicado','email-duplicado'].includes(cenario) || (cenario==='tentar-novamente' && requests.length===1);
        return {ok:!fail,json:async()=>{
            if(cenario==='html')throw new SyntaxError("Unexpected token '<'");
            return {status:!fail,message:fail?'Código inválido ou envio indisponível':'Voto registrado',codigo:'RECIBO',csrf_name:'csrf',csrf_hash:'novo-'+requests.length};
        }};
    }});
    if(cenario==='excesso') {
        opcoes[limite].checked=true;
        handlers['lista-change']({target:opcoes[limite]});
        assert.equal(opcoes[limite].checked,false);
        assert.equal(modais[0].title,'Limite de projetos');
        return;
    }
    if(['poucos','incompleto','email'].includes(cenario)) {
        assert.equal(botao.disabled,true); await handlers.submit({preventDefault(){}});
        assert.equal(requests.length,0);return;
    }
    assert.equal(botao.disabled,false);
    await handlers.submit({preventDefault(){}});
    if(['sucesso','tentar-novamente'].includes(cenario)) {
        const esperado=cenario==='tentar-novamente'?2:1;
        assert.equal(requests.length,esperado);
        const ultimo=requests.at(-1);
        assert.equal(ultimo.url,'votar'); assert.equal(ultimo.body.get('codigo'),null);
        assert.equal(ultimo.body.get('ip'),null); assert.equal(ultimo.body.get('ip_votante'),null);
        assert.equal(ultimo.body.getAll('projetos[]').length,limite);
        assert.equal([...ultimo.body.keys()].filter(k=>k.startsWith('notas[')).length,limite*5);
        assert.equal(ultimo.body.get(`notas[${limite}][impacto]`),'4');
        if(esperado===2)assert.equal(ultimo.body.get('csrf'),'novo-1');
        assert.equal(modais.at(-1).icon,'success');
        assert.equal(botao.disabled,true);assert.equal(email.readOnly,true);
        await handlers.submit({preventDefault(){}});assert.equal(requests.length,esperado,'Não reenvia voto concluído');
    } else {
        assert.equal(requests.length,cenario==='cancelar'?0:1);assert.equal(botao.disabled,false);
        assert(opcoes.every(p=>!p.disabled),'Seleção restaurada após cancelamento ou falha');
        if(cenario==='html')assert(mensagens[0].includes('O servidor não conseguiu processar'));
    }
}
(async()=>{
    for(const c of ['sucesso','tentar-novamente','cancelar','falha-envio','html','ip-duplicado','email-duplicado','excesso','incompleto','poucos','email']) await executar(c);
    await executar('sucesso',1);await executar('sucesso',2);
    console.log('OK: limites 1/2/3, excesso, notas incompletas, e-mail, envio direto, IP duplicado, CSRF, cancelamento e falhas.');
})().catch(e=>{console.error(e);process.exitCode=1;});