const fs=require('node:fs'),vm=require('node:vm'),assert=require('node:assert/strict'),path=require('node:path');
const view=fs.readFileSync(path.join(__dirname,'../application/views/atitude-farmaceutica/inscricao_view.php'),'utf8');
function elemento(){
    const classes=new Set(['border-gray-300']);
    return {value:'',name:'',tagName:'INPUT',disabled:false,dataset:{},attributes:{},handlers:{},classes,
        setAttribute(nome,valor){this.attributes[nome]=String(valor);},
        addEventListener(evento,fn){this.handlers[evento]=fn;},
        insertAdjacentElement(posicao,nota){this.nota=nota;},
        checkValidity(){return true;},
        classList:{toggle(nome,ligar){if(ligar)classes.add(nome);else classes.delete(nome);},add(nome){classes.add(nome);},remove(nome){classes.delete(nome);}}
    };
}
const campos={},avisos=[];
const context={document:{querySelector:selector=>{
    const nome=/name="([^"]+)"/.exec(selector)[1];
    if(!campos[nome])campos[nome]=Object.assign(elemento(),{name:nome});
    return campos[nome];
},createElement:()=>elemento(),getElementById:()=>({querySelectorAll:()=>Object.values(campos)})},Swal:{fire:dados=>avisos.push(dados)},errosValidacao:[],validarDataInicio:()=>true};
vm.createContext(context);
vm.runInContext(view.slice(view.indexOf('        const limitesTextos ='),view.indexOf('        const dropArea =')),context);
const limites={nome_projeto:150,justificativa:150,recursos:100,beneficios_alcancados:250,objetivos_alcancados:250};
for(const [nome,limite] of Object.entries(limites)){
    const campo=campos[nome];
    assert.equal(campo.attributes.maxlength,String(limite));
    campo.value='á'.repeat(limite-1);campo.handlers.input();assert(!campo.classes.has('border-red-500'));
    campo.value+='á';campo.handlers.input();assert(campo.classes.has('border-red-500'));assert(!campo.classes.has('border-gray-300'));
    assert(campo.nota.textContent.includes('Limite máximo atingido'));assert(campo.nota.className.includes('text-red-600'));
    campo.value='á'.repeat(limite+20);campo.handlers.input();assert.equal(Array.from(campo.value).length,limite);
    campo.value=campo.value.slice(0,-1);campo.handlers.input();assert(!campo.classes.has('border-red-500'));assert(!campo.nota.textContent.includes('atingido'));
    assert(new RegExp('name="'+nome+'" maxlength="'+limite+'"').test(view),'Atributo HTML de '+nome);
}
const pessoas=campos.numero_pessoas;
pessoas.value='9999';pessoas.handlers.input();assert.equal(pessoas.value,'999');assert(pessoas.classes.has('border-red-500'));assert(pessoas.nota.textContent.includes('3/3 dígitos'));
pessoas.value='1e3';pessoas.handlers.input();assert.equal(pessoas.value,'999','Colagem de notação científica é rejeitada');
for(const key of ['e','E','+','-','.',',']){let bloqueado=false;pessoas.handlers.keydown({key,preventDefault(){bloqueado=true;}});assert(bloqueado);}
pessoas.value='99';pessoas.handlers.input();assert(!pessoas.classes.has('border-red-500'));
assert.match(view,/name="numero_pessoas"[^>]+max="999"[^>]+maxlength="3"/);
assert.equal(avisos.length,0,'Os campos solicitados usam aviso de apoio sem pop-ups repetidos');
for(const nome of ['resumo_projeto','descricao_projeto']){const campo=campos[nome];campo.value='a'.repeat(Number(campo.attributes.maxlength));campo.handlers.input();campo.handlers.input();}
assert.equal(avisos.length,2,'Resumo e descrição mantêm o Swal uma vez ao atingir o limite');
campos.nome_projeto.value='a'.repeat(150);campos.nome_projeto.handlers.input();
vm.runInContext(view.slice(view.indexOf('        function validateStep(step)'),view.indexOf('        function updateUI()')),context);
assert.equal(context.validateStep(2),true);assert(campos.nome_projeto.classes.has('border-red-500'),'Avançar não apaga o destaque de limite atingido');
console.log('OK: limites, colagem excedente, borda/aviso, redução de texto, números até 999 e valor máximo válido para envio.');
