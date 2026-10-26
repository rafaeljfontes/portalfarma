const fs=require('node:fs'),vm=require('node:vm'),assert=require('node:assert/strict'),path=require('node:path');
const view=fs.readFileSync(path.join(__dirname,'../application/views/atitude-farmaceutica/inscricao_view.php'),'utf8');
const code=view.slice(view.indexOf('        function renderGaleriaPrincipal()'),view.indexOf('        // Submissão via AJAX'));
class Elemento {
    constructor(tag){this.tag=tag;this.children=[];this.style={};this.handlers={};this.value='';}
    append(...items){items.forEach(item=>{item.parentElement=this;this.children.push(item);});}
    appendChild(item){this.append(item);}
    replaceChildren(){this.children=[];}
    addEventListener(event,fn){this.handlers[event]=fn;}
    setAttribute(key,value){this[key]=value;}
    set innerHTML(value){throw Error('Não inserir conteúdo de formulário como HTML');}
}
const gallery=new Elemento('div'),index={value:'1'},button=new Elemento('button'),form={};
const files=[{name:'primeira.png'},{name:'segunda.png'}],states=new Map(files.map((f,i)=>[f,{id:i,ready:Promise.resolve({id:i})}]));
const ids={'galeria-principal-container':gallery,'imagem_principal_idx':index,'btn-preview-projeto':button,'form-inscricao':form};
const opcoes=()=>gallery.children.flatMap(label=>label.children.filter(c=>c.tag==='input'));
const modais=[],urls=[],revogadas=[];
const context={document:{getElementById:id=>ids[id],createElement:tag=>new Elemento(tag),querySelectorAll:()=>opcoes()},
    selectedFiles:files,adjustedFiles:[{name:'recorte1'},{name:'recorte2'}],ajustesConfirmados:true,miniaturasPrincipal:new WeakMap(),
    obterAjuste:file=>states.get(file),desenharRecorte:(canvas,state)=>{canvas.imagem=state.id;},
    URL:{createObjectURL:file=>{urls.push(file);return 'blob:teste';},revokeObjectURL:url=>revogadas.push(url)},
    FormData:class{get(key){return {nome_projeto:'<script>nome</script>',resumo_projeto:'Resumo do projeto',data_inicio:'2026-10-16'}[key];}},
    Swal:{fire:async options=>modais.push(options)}};
vm.createContext(context);vm.runInContext(code,context);
(async()=>{
    context.renderGaleriaPrincipal();await Promise.resolve();
    assert.equal(opcoes().length,2);assert.equal(opcoes()[1].checked,true);assert.equal(index.value,1);
    assert.equal(gallery.children[1].children[2].imagem,1,'Miniatura usa o recorte correspondente');
    await button.handlers.click();assert.equal(urls[0].name,'recorte2');assert.equal(revogadas[0],'blob:teste');
    const card=modais[0].html;assert.equal(card.children[0].src,'blob:teste');
    assert.equal(card.children[1].children[0].textContent,'<script>nome</script>');
    assert.equal(card.children[1].children[1].textContent,'Resumo do projeto');
    assert.equal(card.children[1].children[2].children[1].textContent,'16/10/2026');
    context.ajustesConfirmados=false;await button.handlers.click();assert.equal(modais[1].icon,'warning');assert.equal(urls.length,1);
    context.setImagemPrincipal(0);context.renderGaleriaPrincipal();assert.equal(opcoes()[0].checked,true);
    const removal=view.slice(view.indexOf('        function removeFile(index)'),view.indexOf('        // Navegação Steps'));
    const r={selectedFiles:[1,2,3],document:{getElementById:()=>index},renderPreviews(){}};
    vm.createContext(r);vm.runInContext(removal,r);index.value='2';r.removeFile(0);assert.equal(index.value,1);r.removeFile(1);assert.equal(index.value,0);
    const passo3=view.slice(view.indexOf('id="step-3"'),view.indexOf('id="step-4"'));
    const passo4=view.slice(view.indexOf('id="step-4"'),view.indexOf('<!-- Botões de Navegação -->'));
    assert(passo3.includes('id="galeria-principal-container"'));assert(!passo4.includes('id="galeria-principal-container"'));assert(passo4.includes('id="btn-preview-projeto"'));
    console.log('OK: principal no passo 3, seleção preservada, remoção, Preview do recorte, data e conteúdo seguro.');
})().catch(e=>{console.error(e);process.exitCode=1;});
