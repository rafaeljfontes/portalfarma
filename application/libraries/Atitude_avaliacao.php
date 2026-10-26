<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Atitude_avaliacao
{
    // Regras internas: não enviar pesos ou notas calculadas para a interface.
    private $pesos = array('relevancia' => 3, 'impacto' => 2, 'pessoas' => 2, 'duracao' => 1, 'beneficios' => 2);

    public function preparar($notas, $ids)
    {
        if (!is_array($notas) || !$ids || count($notas) !== count($ids)) return null;
        $esperados = array_map('strval', $ids);
        $recebidos = array_map('strval', array_keys($notas));
        sort($esperados); sort($recebidos);
        if ($esperados !== $recebidos) return null;
        $linhas = array();
        foreach ($ids as $id) {
            $avaliacao = $notas[$id] ?? null;
            if (!is_array($avaliacao) || count($avaliacao) !== count($this->pesos)) return null;
            $linha = array('id_projeto' => (int) $id); $soma = 0;
            foreach ($this->pesos as $criterio => $peso) {
                $nota = $avaliacao[$criterio] ?? null;
                if ((!is_string($nota) && !is_int($nota)) || !preg_match('/\A[1-5]\z/', (string) $nota)) return null;
                $linha[$criterio] = (int) $nota;
                $soma += (int) $nota * $peso;
            }
            $linha['nota_final'] = $soma / array_sum($this->pesos);
            $linhas[] = $linha;
        }
        return $linhas;
    }
}
