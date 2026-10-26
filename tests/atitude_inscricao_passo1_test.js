const fs=require('node:fs'),vm=require('node:vm'),assert=require('node:assert/strict'),path=require('node:path');
const view=fs.readFileSync(path.join(__dirname,'../application/views/atitude-farmaceutica/inscricao_view.php'),'utf8');
const campos=[];
const context={errosValidacao:[],window:{AtitudeSolicitante:{confirmado:()=>true}},document:{getElementById:()=>({querySelectorAll:()=>campos})},selectedFiles:[]};
vm.createContext(context);
vm.runInContext(view.slice(view.indexOf('        function validateStep(step)'),view.indexOf('        function updateUI()')),context);
function campo(name,value,extra={}) {return {name,value,tagName:'INPUT',disabled:false,checkValidity:()=>true,classList:{add(){},remove(){}},...extra};}
const registro=campo('numero_crf','26338'),celular=campo('celular','(31) 98072-046'),cidade=campo('cidade_farmaceutico','',{tagName:'SELECT'});
campos.push(registro,celular,cidade);
assert.equal(context.validateStep(1),false);
assert.equal(context.errosValidacao.length,2);
assert(context.errosValidacao.some(msg=>msg.includes('celular completo')));
assert(context.errosValidacao.some(msg=>msg.includes('Cidade')));
assert(!context.errosValidacao.some(msg=>msg.includes('registro')));
celular.value='(31) 98072-0469';cidade.value='Belo Horizonte';
assert.equal(context.validateStep(1),true);assert.equal(context.errosValidacao.length,0);
cidade.disabled=true;assert.equal(context.validateStep(1),true,'Cidade da Empresa desabilitada não impede avanço');
registro.value='';assert.equal(context.validateStep(1),false);assert(context.errosValidacao[0].includes('registro'));
assert(!view.includes("$('#buscar-solicitante').on"),'A busca tem apenas o handler do arquivo externo');
// Verifica digitação completa e colagem sem perda de dígitos na máscara.
const telefone={value:'',selectionStart:0,handlers:{},addEventListener(e,fn){this.handlers[e]=fn;},setSelectionRange(pos){this.selectionStart=pos;}};
const mascara={document:{getElementById:()=>telefone}};
vm.createContext(mascara);
vm.runInContext(view.slice(view.indexOf('        const celularInput ='),view.indexOf('        // Drag and drop event listeners')),mascara);
for(const digito of '31980720469') {
    const pos=telefone.selectionStart;
    telefone.value=telefone.value.slice(0,pos)+digito+telefone.value.slice(pos);
    telefone.selectionStart=pos+1;telefone.handlers.input();
}
assert.equal(telefone.value,'(31) 98072-0469');
telefone.value='31999999999';telefone.selectionStart=11;telefone.handlers.input();assert.equal(telefone.value,'(31) 99999-9999');
console.log('OK: registro preenchido aceito, celular/cidade com mensagens específicas, cidade desabilitada e máscara completa.');
