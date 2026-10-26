<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Inscricao_logs_model extends CI_Model
{
    public function consultar($busca = '', $pagina = 1, $porPagina = 50, $pasta = null)
    {
        $pasta = $pasta ?? APPPATH.'logs/inscricoes/';
        $tentativas = [];
        $avisos = 0;
        foreach (glob(rtrim($pasta, '/\\').'/inscricoes-????-??-??.txt') ?: [] as $arquivo) {
            $handle = @fopen($arquivo, 'rb');
            if (!$handle) { $avisos++; continue; }
            while (($linha = fgets($handle)) !== false) {
                $registro = json_decode($linha, true);
                if (!is_array($registro) || !is_string($registro['tentativa'] ?? null)
                    || !is_string($registro['data_hora'] ?? null) || !is_array($registro['dados'] ?? null)
                    || !in_array($registro['evento'] ?? '', ['inicio', 'resultado'], true)) {
                    $avisos++;
                    continue;
                }
                $id = $registro['tentativa'];
                // Mantém um resultado por tentativa, inclusive quando o início e
                // o término foram gravados em dias diferentes.
                if (!isset($tentativas[$id]) || $registro['evento'] === 'resultado') {
                    $tentativas[$id] = $registro;
                }
            }
            fclose($handle);
        }
        $termo = $this->normalizar($busca);
        $cpf = preg_match('/^[0-9.\s-]+$/', $busca) ? preg_replace('/\D/', '', $busca) : '';
        $registros = array_values(array_filter($tentativas, function ($registro) use ($termo, $cpf) {
            if ($termo === '') return true;
            $dados = $registro['dados'];
            $nome = is_scalar($dados['nome'] ?? null) ? (string) $dados['nome'] : '';
            $curso = is_scalar($dados['curso_titulo'] ?? null) ? (string) $dados['curso_titulo'] : '';
            $documento = is_scalar($dados['cpf'] ?? null) ? (string) $dados['cpf'] : '';
            return strpos($this->normalizar($nome.' '.$curso), $termo) !== false
                || ($cpf !== '' && strpos(preg_replace('/\D/', '', $documento), $cpf) !== false);
        }));
        usort($registros, function ($a, $b) {
            return strcmp($b['data_hora'], $a['data_hora']) ?: strcmp($b['tentativa'], $a['tentativa']);
        });
        $porPagina = max(1, min(100, (int) $porPagina));
        $total = count($registros);
        $paginas = max(1, (int) ceil($total / $porPagina));
        $pagina = max(1, min((int) $pagina, $paginas));
        return ['registros'=>array_slice($registros, ($pagina - 1) * $porPagina, $porPagina),
            'total'=>$total, 'pagina'=>$pagina, 'paginas'=>$paginas, 'avisos'=>$avisos];
    }

    private function normalizar($texto)
    {
        $texto = mb_strtolower(trim((string) $texto), 'UTF-8');
        return strtr($texto, [
            'á'=>'a', 'à'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a', 'å'=>'a',
            'é'=>'e', 'è'=>'e', 'ê'=>'e', 'ë'=>'e',
            'í'=>'i', 'ì'=>'i', 'î'=>'i', 'ï'=>'i',
            'ó'=>'o', 'ò'=>'o', 'ô'=>'o', 'õ'=>'o', 'ö'=>'o',
            'ú'=>'u', 'ù'=>'u', 'û'=>'u', 'ü'=>'u', 'ç'=>'c', 'ñ'=>'n', 'ý'=>'y', 'ÿ'=>'y'
        ]);
    }
}
