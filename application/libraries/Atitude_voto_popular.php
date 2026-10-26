<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Atitude_voto_popular
{
    public function criterios()
    {
        return array('relevancia' => 'Relevância da iniciativa', 'impacto' => 'Impacto gerado',
            'pessoas' => 'Número de pessoas alcançadas', 'duracao' => 'Duração/continuidade da iniciativa',
            'beneficios' => 'Benefícios alcançados');
    }

    public function preparar($ids, $notas, $limite)
    {
        if (!is_int($limite) || $limite < 1 || $limite > 100 || !is_array($ids) || count($ids) !== $limite || !is_array($notas) || count($notas) !== $limite) return null;
        $normalizados = array();
        foreach ($ids as $id) {
            if ((!is_string($id) && !is_int($id)) || !preg_match('/\A[1-9][0-9]*\z/', (string) $id) || !filter_var($id, FILTER_VALIDATE_INT, array('options' => array('min_range' => 1)))) return null;
            $normalizados[] = (int) $id;
        }
        if (count(array_unique($normalizados)) !== $limite) return null;
        sort($normalizados, SORT_NUMERIC);
        $chaves = array_map('strval', array_keys($notas)); $esperados = array_map('strval', $normalizados);
        sort($chaves); sort($esperados);
        if ($chaves !== $esperados) return null;
        $linhas = array();
        foreach ($normalizados as $id) {
            $avaliacao = $notas[$id];
            if (!is_array($avaliacao) || count($avaliacao) !== 5) return null;
            $linha = array('id_proejto' => $id);
            foreach ($this->criterios() as $criterio => $rotulo) {
                $nota = $avaliacao[$criterio] ?? null;
                if ((!is_string($nota) && !is_int($nota)) || !preg_match('/\A[1-5]\z/', (string) $nota)) return null;
                $linha[$criterio] = (int) $nota;
            }
            $linhas[] = $linha;
        }
        return $linhas;
    }

    public function normalizar_ip($ip)
    {
        if (!is_string($ip) || !filter_var($ip, FILTER_VALIDATE_IP)) return null;
        $binario = inet_pton($ip);
        if ($binario === false) return null;
        // IPv4 e sua forma IPv6 mapeada representam o mesmo endereço.
        if (strlen($binario) === 16 && substr($binario, 0, 12) === hex2bin('00000000000000000000ffff')) $binario = substr($binario, 12);
        $normalizado = strtolower(inet_ntop($binario));
        return in_array($normalizado, array('0.0.0.0', '::'), true) ? null : $normalizado;
    }
}
