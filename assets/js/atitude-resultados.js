(() => {
    'use strict';
    const criterios = { duracao: 'Duração/continuidade', impacto: 'Impacto gerado', pessoas: 'Pessoas alcançadas', beneficios: 'Benefícios alcançados', relevancia: 'Relevância' };
    const nota = valor => valor === null || valor === undefined ? '—' : Number(valor).toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 6 });
    const notaFinal = valor => valor === null || valor === undefined ? '—' : Number(valor).toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
    function elemento(tag, texto, classe) {
        const item = document.createElement(tag);
        if (texto !== undefined) item.textContent = texto;
        if (classe) item.className = classe;
        return item;
    }
    window.AtitudeResultados = {
        montar(data) {
            const conteudo = elemento('div', undefined, 'atitude-resultados');
            const resumo = elemento('div', undefined, 'atitude-resultados-resumo');
            [data.projetos.length + ' projetos aprovados', data.total_avaliacoes_comissao + ' avaliações da comissão', data.total_avaliacoes_populares + ' avaliações populares com notas'].forEach(texto => resumo.appendChild(elemento('span', texto)));
            conteudo.appendChild(resumo);
            conteudo.appendChild(elemento('p', 'Nota final = [(média da comissão × 2) + média popular] ÷ 3.', 'atitude-resultados-formula'));
            conteudo.appendChild(elemento('p', 'Comissão: média das notas ponderadas registradas. Popular: média das notas dos cinco critérios de cada voto.', 'atitude-resultados-nota'));
            if (data.total_classificados > 0) {
                const podio = elemento('div', undefined, 'atitude-resultados-podio');
                for (let lugar = 1; lugar <= 3; lugar++) {
                    const card = elemento('div', undefined, 'atitude-podio-lugar lugar-' + lugar);
                    card.appendChild(elemento('h3', lugar + 'º lugar'));
                    const vencedores = data.projetos.filter(projeto => projeto.posicao === lugar);
                    vencedores.forEach(projeto => {
                        const item = elemento('p');
                        item.append(elemento('strong', projeto.nome), elemento('span', 'Nota final: ' + notaFinal(projeto.nota_final)));
                        card.appendChild(item);
                    });
                    if (!vencedores.length) card.appendChild(elemento('p', 'Sem classificação'));
                    podio.appendChild(card);
                }
                conteudo.appendChild(podio);
            } else {
                conteudo.appendChild(elemento('p', 'Aguardando avaliações da comissão para calcular a classificação.', 'atitude-resultados-pendente'));
            }
            conteudo.appendChild(elemento('h2', 'Classificação dos projetos'));
            const scroll = elemento('div', undefined, 'atitude-resultados-tabela-scroll');
            const tabela = elemento('table', undefined, 'atitude-resultados-tabela');
            tabela.appendChild(elemento('caption', 'Projetos aprovados, ordenados pela nota final e pelos critérios de desempate.'));
            const cabecalho = elemento('thead'), cabecalhoLinha = elemento('tr');
            ['Posição', 'Projeto', 'Média comissão', 'Média popular', 'Nota final', 'Avaliações comissão / público', 'Desempate (comissão)'].forEach(texto => {
                const th = elemento('th', texto); th.setAttribute('scope', 'col'); cabecalhoLinha.appendChild(th);
            });
            cabecalho.appendChild(cabecalhoLinha); tabela.appendChild(cabecalho);
            const corpo = elemento('tbody');
            data.projetos.forEach(projeto => {
                const linha = elemento('tr');
                linha.append(elemento('td', projeto.posicao === null ? 'Aguardando avaliações' : projeto.posicao + 'º'), elemento('td', projeto.nome), elemento('td', nota(projeto.nota_comissao)), elemento('td', nota(projeto.nota_popular)));
                const final = elemento('td'); final.appendChild(elemento('strong', notaFinal(projeto.nota_final))); linha.appendChild(final);
                linha.appendChild(elemento('td', projeto.avaliacoes_comissao + ' / ' + projeto.avaliacoes_populares));
                const detalhe = elemento('td'), medias = elemento('details');
                medias.appendChild(elemento('summary', 'Ver médias'));
                Object.entries(criterios).forEach(([chave, rotulo]) => medias.appendChild(elemento('p', rotulo + ': ' + nota(projeto.criterios_comissao[chave]))));
                detalhe.appendChild(medias); linha.appendChild(detalhe); corpo.appendChild(linha);
            });
            if (!data.projetos.length) {
                const linha = elemento('tr'), celula = elemento('td', 'Nenhum projeto aprovado disponível.');
                celula.colSpan = 7; linha.appendChild(celula); corpo.appendChild(linha);
            }
            tabela.appendChild(corpo); scroll.appendChild(tabela); conteudo.appendChild(scroll);
            conteudo.appendChild(elemento('p', 'Desempate: duração/continuidade → impacto → pessoas alcançadas → benefícios → relevância. Persistindo igualdade em todos os critérios, os projetos compartilham a posição.', 'atitude-resultados-nota'));
            conteudo.appendChild(elemento('p', 'Valores arredondados apenas para exibição. A classificação usa os valores integrais, sem arredondamento prévio. Sem avaliação popular válida, a nota popular é 0. Projetos sem avaliação da comissão ficam sem classificação.', 'atitude-resultados-nota'));
            if (data.votos_sem_notas > 0) conteudo.appendChild(elemento('p', data.votos_sem_notas + ' voto(s) antigo(s) sem notas preservado(s), excluído(s) das médias populares.', 'atitude-resultados-nota'));
            conteudo.appendChild(elemento('h2', 'Nota final por projeto'));
            const grafico = elemento('div', undefined, 'atitude-resultados-grafico');
            data.projetos.forEach(projeto => {
                const linha = elemento('div', undefined, 'atitude-grafico-linha');
                const label = elemento('div', undefined, 'atitude-grafico-label');
                label.append(elemento('span', projeto.nome), elemento('strong', projeto.nota_final === null ? 'Aguardando avaliações' : notaFinal(projeto.nota_final) + ' / 5'));
                const trilho = elemento('div', undefined, 'atitude-grafico-trilho'); trilho.setAttribute('aria-hidden', 'true');
                const barra = elemento('div', undefined, 'atitude-grafico-barra'); barra.style.width = (projeto.nota_final === null ? 0 : projeto.nota_final / 5 * 100) + '%';
                trilho.appendChild(barra); linha.append(label, trilho); grafico.appendChild(linha);
            });
            conteudo.appendChild(grafico);
            return conteudo;
        }
    };
})();
