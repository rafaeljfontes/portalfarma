const fs = require('node:fs'), vm = require('node:vm'), assert = require('node:assert/strict'), path = require('node:path');
const script = fs.readFileSync(path.join(__dirname, '../assets/js/atitude-solicitante.js'), 'utf8');
function campo(value = '') { return {value, disabled:false, handlers:{}, addEventListener(event, fn){this.handlers[event]=fn;}}; }
async function executar(cenario) {
    const radios = [Object.assign(campo('farmaceutico'), {checked:cenario!=='empresa'}), Object.assign(campo('empresa'), {checked:cenario==='empresa'})];
    const registro = campo(cenario==='registro-invalido'?'ABC':'123'), nome = campo(), cidade = campo(), status = {}, label = {}, next = {};
    const cidadeEmpresa = campo();
    cidade.options = [{value:''},{value:'Belo Horizonte'},{value:'Contagem'}];
    registro.dataset = {pfUrl:'/pf',pjUrl:'/pj'};
    const csrf = {name:'csrf',value:'original'};
    const email = campo(), celular = campo();
    const botaoBuscar = campo();
    const campos = [nome,cidade,email,celular,cidadeEmpresa];
    const form = {querySelectorAll(selector){return selector.startsWith('#step-1') ? campos : radios;}};
    const ids = {'form-inscricao':form,numero_crf:registro,nome,cidade,'cidade-empresa':cidadeEmpresa,'buscar-solicitante':botaoBuscar,'solicitante-status':status,'inscricao-csrf':csrf,'solicitante-nome-label':label,'btn-next':next};
    const chamadas = [], avisos = [], window = {};
    const timers = new Map(); let timerId = 0;
    vm.runInNewContext(script, {window, document:{getElementById:id=>ids[id]}, URLSearchParams,
        setTimeout:fn=>{timers.set(++timerId,fn);return timerId;}, clearTimeout:id=>timers.delete(id),
        Swal:{fire:async data=>avisos.push(data)},
        jQuery:Object.assign(function(alvo){
            if(typeof alvo==='function'){alvo();return;}
            return {on:(evento,handler)=>alvo.addEventListener(evento,handler)};
        }, {ajax(options){
            chamadas.push({url:options.url,body:new URLSearchParams(options.data)});
            assert.equal(options.type,'POST');assert.equal(options.dataType,'json');
            assert.equal(next.disabled,true); assert.equal(registro.disabled,true); assert.equal(botaoBuscar.disabled,true);
            if(cenario==='html'){options.error({status:200},'parsererror','HTML');return;}
            const dados = cenario==='nulo'?null:cenario==='danger'?{type:'danger',status:false,message:'Inscrição não liberada'}:cenario==='negativo'?{type:'error',status:false,message:'Não foram encontrados dados na base de dados do CRF/MG. Não será possível realizar a inscrição.',csrf_name:'csrf',csrf_hash:'novo'}:
                    {type:'success',status:true,Nome:'Farmacêutico de teste',RazaoSocial:'Empresa de teste',Cidade:cenario==='incompleto'?'':'Belo Horizonte',csrf_name:'csrf',csrf_hash:'novo'};
            if(cenario==='negativo')options.error({status:404,responseJSON:dados},'error','Not Found');
            else options.success(dados,'success',{status:200});
        }})});
    assert.equal(window.AtitudeSolicitante.confirmado(),false);
    assert(campos.every(campo=>campo.disabled));
    if(cenario==='registro-invalido') {
        await registro.handlers.blur(); assert.equal(chamadas.length,0); assert.equal(avisos.length,1);
        await registro.handlers.keydown({key:'Enter',preventDefault(){}});
    } else {
        registro.handlers.input(); registro.handlers.input();
        assert.equal(timers.size,0); assert.equal(chamadas.length,0);
        await registro.handlers.keydown({key:'Enter',preventDefault(){}});
        assert.equal(chamadas.length,0);
        if(cenario==='empresa')await botaoBuscar.handlers.click();
        else await registro.handlers.blur();
        assert.equal(chamadas.length,1);
        await registro.handlers.blur(); assert.equal(chamadas.length,1);
        await botaoBuscar.handlers.click(); assert.equal(chamadas.length,1);
        assert.equal(timers.size,0);
    }
    if(cenario==='registro-invalido'){assert.equal(chamadas.length,0);assert.equal(window.AtitudeSolicitante.confirmado(),false);return;}
    assert.equal(chamadas[0].url,cenario==='empresa'?'/pj':'/pf');
    assert.equal(chamadas[0].body.get('crfmg'),'123');assert.equal(chamadas[0].body.get('contexto'),'atitude_farmaceutica');
    assert.equal(next.disabled,false);assert.equal(registro.disabled,false);assert.equal(botaoBuscar.disabled,false);
    if(['farmaceutico','empresa'].includes(cenario)) {
        assert.equal(window.AtitudeSolicitante.confirmado(),true);
        assert([nome,email,celular].every(campo=>!campo.disabled));
        assert.equal(cidade.disabled,cenario==='empresa');
        assert.equal(cidadeEmpresa.disabled,cenario!=='empresa');
        assert.equal(nome.value,cenario==='empresa'?'Empresa de teste':'Farmacêutico de teste');
        assert.equal(cidade.value,cenario==='empresa'?'Belo Horizonte':'');
        if(cenario==='farmaceutico')cidade.value='Contagem';
        const cidadesEnviadas=[cidade,cidadeEmpresa].filter(campo=>!campo.disabled).map(campo=>campo.value);
        assert.deepEqual(cidadesEnviadas,[cenario==='empresa'?'Belo Horizonte':'Contagem']);
        assert.equal(csrf.value,'novo');assert.equal(avisos.length,0);
        registro.value='124';registro.handlers.input();assert.equal(window.AtitudeSolicitante.confirmado(),false);assert.equal(nome.value,'');
        assert(campos.every(campo=>campo.disabled));
        radios[0].checked=false;radios[1].checked=true;radios[1].handlers.change();assert.equal(label.textContent,'*Razão social:');
    } else {
        assert.equal(window.AtitudeSolicitante.confirmado(),false);assert.equal(nome.value,'');assert.equal(cidade.value,'');
        assert(campos.every(campo=>campo.disabled));
        assert.equal(avisos[0].title,'Inscrição não liberada');
        if(cenario==='negativo')assert(avisos[0].text.includes('Não será possível realizar a inscrição'));
    }
}
(async()=>{for(const c of ['farmaceutico','empresa','negativo','registro-invalido','incompleto','html','nulo','danger'])await executar(c);console.log('OK: busca PF/PJ, preenchimento, CSRF, invalidação e bloqueio por retorno negativo/nulo/danger.');})().catch(e=>{console.error(e);process.exitCode=1;});
