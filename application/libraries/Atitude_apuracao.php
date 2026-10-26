<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Atitude_apuracao
{
    private $desempate = array('duracao', 'impacto', 'pessoas', 'beneficios', 'relevancia');

    private function mdc($a, $b)
    {
        while ($b !== 0) { $resto = $a % $b; $a = $b; $b = $resto; }
        return $a;
    }

    private function fracao($numerador, $denominador)
    {
        if (!is_int($numerador) || !is_int($denominador) || $numerador < 0 || $denominador < 1) throw new OverflowException('Apuração fora dos limites numéricos.');
        $divisor = $this->mdc($numerador, $denominador);
        return array(intdiv($numerador, $divisor), intdiv($denominador, $divisor));
    }

    // Compara frações por divisões inteiras, sem arredondar e sem multiplicação
    // cruzada que poderia ultrapassar o limite de inteiros em bases grandes.
    private function comparar_fracoes($a, $b)
    {
        $sinal = 1;
        while (true) {
            $qa = intdiv($a[0], $a[1]); $qb = intdiv($b[0], $b[1]);
            if ($qa !== $qb) return $sinal * ($qa <=> $qb);
            $ra = $a[0] % $a[1]; $rb = $b[0] % $b[1];
            if ($ra === 0 || $rb === 0) return $sinal * ($ra <=> $rb);
            $a = array($a[1], $ra); $b = array($b[1], $rb); $sinal *= -1;
        }
    }

    private function comparar_classificacao($a, $b)
    {
        $comparacao = $this->comparar_fracoes($a['_final'], $b['_final']);
        if ($comparacao !== 0) return $comparacao;
        foreach ($this->desempate as $criterio) {
            $comparacao = $this->comparar_fracoes($a['_criterios'][$criterio], $b['_criterios'][$criterio]);
            if ($comparacao !== 0) return $comparacao;
        }
        return 0;
    }

    public function calcular($registros)
    {
        $projetos = array(); $totalVotos = 0; $totalComissao = 0; $totalPopulares = 0;
        foreach ($registros as $registro) {
            $c = (int) $registro->avaliacoes_comissao; $p = (int) $registro->avaliacoes_populares;
            $mediaComissao = $c > 0 ? $this->fracao((int) $registro->soma_comissao_centavos, 100 * $c) : null;
            $mediaPopular = $p > 0 ? $this->fracao((int) $registro->soma_popular, 5 * $p) : array(0, 1);
            $final = null; $criterios = array(); $fracoesCriterios = array();
            if ($mediaComissao !== null && $mediaPopular !== null) {
                $divisor = $this->mdc($mediaComissao[1], $mediaPopular[1]);
                $fatorC = intdiv($mediaPopular[1], $divisor); $fatorP = intdiv($mediaComissao[1], $divisor);
                $final = $this->fracao(2 * $mediaComissao[0] * $fatorC + $mediaPopular[0] * $fatorP, 3 * $mediaComissao[1] * $fatorC);
            }
            foreach ($this->desempate as $criterio) {
                $fracao = $c > 0 ? $this->fracao((int) $registro->{'soma_' . $criterio}, $c) : null;
                $fracoesCriterios[$criterio] = $fracao;
                $criterios[$criterio] = $fracao === null ? null : $fracao[0] / $fracao[1];
            }
            $projetos[] = array(
                'id' => (int) $registro->id, 'nome' => $registro->nome_projeto,
                'votos' => (int) $registro->votos, 'avaliacoes_comissao' => $c, 'avaliacoes_populares' => $p,
                'votos_sem_notas' => (int) $registro->votos - $p,
                'nota_comissao' => $mediaComissao === null ? null : $mediaComissao[0] / $mediaComissao[1],
                'nota_popular' => $mediaPopular === null ? null : $mediaPopular[0] / $mediaPopular[1],
                'nota_final' => $final === null ? null : $final[0] / $final[1],
                'criterios_comissao' => $criterios, 'posicao' => null,
                '_final' => $final, '_criterios' => $fracoesCriterios
            );
            $totalVotos += (int) $registro->votos; $totalComissao += $c; $totalPopulares += $p;
        }
        usort($projetos, function ($a, $b) {
            if ($a['_final'] === null || $b['_final'] === null) {
                if ($a['_final'] !== $b['_final']) return $a['_final'] === null ? 1 : -1;
            } else {
                $comparacao = $this->comparar_classificacao($a, $b);
                if ($comparacao !== 0) return -$comparacao;
            }
            // Estabilidade visual; o ID nunca define um vencedor num empate total.
            return $a['id'] <=> $b['id'];
        });
        $posicao = 0; $anterior = null; $classificados = 0;
        foreach ($projetos as &$projeto) {
            if ($projeto['_final'] !== null) {
                if ($anterior === null || $this->comparar_classificacao($anterior, $projeto) !== 0) $posicao++;
                $projeto['posicao'] = $posicao;
                $anterior = $projeto; $classificados++;
            }
            unset($projeto['_final'], $projeto['_criterios']);
        }
        unset($projeto);
        return array('projetos' => $projetos, 'total_votos' => $totalVotos,
            'total_avaliacoes_comissao' => $totalComissao, 'total_avaliacoes_populares' => $totalPopulares,
            'votos_sem_notas' => $totalVotos - $totalPopulares, 'total_classificados' => $classificados);
    }
}
