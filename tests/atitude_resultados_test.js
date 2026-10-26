const assert = require('node:assert/strict');
const fs = require('node:fs');
const vm = require('node:vm');
const path = require('node:path');
class Elemento {
    constructor(tag) { this.tag = tag; this.children = []; this.style = {}; this.attributes = {}; this.texto = ''; }
    set textContent(value) { this.texto = String(value); this.children = []; }
    get textContent() { return this.texto + this.children.map(c => c.textContent).join(' '); }
    set innerHTML(value) { throw Error('Não usar HTML para conteúdo de projetos'); }
    append(...items) { this.children.push(...items); }
    appendChild(item) { this.children.push(item); }
    setAttribute(key, value) { this.attributes[key] = value; }
}
const context = { window: {}, document: { createElement: tag => new Elemento(tag) } };
vm.runInNewContext(fs.readFileSync(path.join(__dirname, '../assets/js/atitude-resultados.js'), 'utf8'), context);
function encontrar(root, fn) { return [...(fn(root) ? [root] : []), ...root.children.flatMap(child => encontrar(child, fn))]; }
function projeto(id, nota, posicao) {
    return { id, nome: id === 1 ? '<img src=x onerror=alert(1)>' : 'Projeto ' + id, nota_comissao: 4, nota_popular: 3,
        nota_final: nota, posicao, avaliacoes_comissao: 2, avaliacoes_populares: 3,
        criterios_comissao: {duracao:4,impacto:4,pessoas:4,beneficios:4,relevancia:4} };
}
const dados = { projetos:[projeto(1,4.5,1),projeto(2,4,2),projeto(3,3,3),projeto(4,null,null)],
    total_avaliacoes_comissao:8,total_avaliacoes_populares:9,total_classificados:3,votos_sem_notas:2 };
let tela = context.window.AtitudeResultados.montar(dados);
assert.equal(encontrar(tela, item => item.tag === 'table').length, 1);
assert.equal(encontrar(tela, item => item.tag === 'thead')[0].children[0].children.length, 7);
assert.equal(encontrar(tela, item => item.tag === 'tbody')[0].children.length, 4);
assert.equal(encontrar(tela, item => item.className?.includes('atitude-podio-lugar')).length, 3);
assert(tela.textContent.includes('4,50') && tela.textContent.includes('Média comissão') && tela.textContent.includes('Média popular'));
assert(tela.textContent.includes('Aguardando avaliações') && tela.textContent.includes('antigo(s) sem notas'));
assert.equal(encontrar(tela, item => item.className === 'atitude-grafico-barra')[0].style.width, '90%');
assert.equal(encontrar(tela, item => item.className === 'atitude-grafico-barra').at(-1).style.width, '0%');
assert.equal(encontrar(tela, item => item.tag === 'img').length, 0, 'Nome do projeto não é interpretado como HTML');
assert(tela.textContent.includes('<img src=x onerror=alert(1)>'));
tela = context.window.AtitudeResultados.montar({...dados,projetos:[projeto(1,null,null)],total_classificados:0});
assert.equal(encontrar(tela, item => item.className === 'atitude-resultados-podio').length, 0);
assert(tela.textContent.includes('Aguardando avaliações da comissão para calcular'));
tela = context.window.AtitudeResultados.montar({...dados,projetos:[],total_classificados:0});
assert(tela.textContent.includes('Nenhum projeto aprovado'));
console.log('OK: pódio, notas, tabela completa, gráfico final, pendências, lista vazia e nomes seguros.');
