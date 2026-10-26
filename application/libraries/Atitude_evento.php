<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Atitude_evento
{
    private $arquivo;
    public function __construct($config = array())
    {
        $this->arquivo = $config['arquivo'] ?? APPPATH . 'cache/atitude/evento.json';
    }
    private function interpretar($conteudo)
    {
        $dados = json_decode($conteudo, true);
        return isset($dados['fase']) && in_array($dados['fase'], array('inscricao', 'votacao', 'encerrado'), true) ? $dados['fase'] : 'encerrado';
    }
    public function obter_fase()
    {
        if (!is_file($this->arquivo)) return 'inscricao';
        $arquivo = @fopen($this->arquivo, 'r');
        if (!$arquivo) return 'encerrado';
        try {
            if (!flock($arquivo, LOCK_SH)) return 'encerrado';
            return $this->interpretar(stream_get_contents($arquivo));
        } finally { fclose($arquivo); }
    }
    public function salvar_fase($fase, $anterior)
    {
        $validas = array('inscricao', 'votacao', 'encerrado');
        if (!in_array($fase, $validas, true) || !in_array($anterior, $validas, true)) return false;
        $existia = is_file($this->arquivo);
        $arquivo = @fopen($this->arquivo, 'c+');
        if (!$arquivo) return false;
        try {
            if (!flock($arquivo, LOCK_EX)) return false;
            $conteudo = stream_get_contents($arquivo);
            $atual = !$existia && $conteudo === '' ? 'inscricao' : $this->interpretar($conteudo);
            if ($atual !== $anterior) return false;
            $dados = json_decode($conteudo, true);
            if (!is_array($dados)) $dados = array();
            $dados['fase'] = $fase;
            $novo = json_encode($dados) . "\n";
            rewind($arquivo);
            if (!ftruncate($arquivo, 0) || fwrite($arquivo, $novo) !== strlen($novo) || !fflush($arquivo)) {
                rewind($arquivo); ftruncate($arquivo, 0); fwrite($arquivo, $conteudo); fflush($arquivo);
                return false;
            }
            return true;
        } finally { fclose($arquivo); }
    }

    public function obter_limite_votacao()
    {
        if (!is_file($this->arquivo)) return 3;
        $arquivo = @fopen($this->arquivo, 'r');
        if (!$arquivo) return 3;
        try {
            if (!flock($arquivo, LOCK_SH)) return 3;
            $dados = json_decode(stream_get_contents($arquivo), true);
            $limite = $dados['limite_projetos_votacao'] ?? 3;
            return is_int($limite) && $limite >= 1 && $limite <= 100 ? $limite : 3;
        } finally { fclose($arquivo); }
    }

    public function salvar_limite_votacao($limite, $anterior)
    {
        if (!is_int($limite) || $limite < 1 || $limite > 100 || !is_int($anterior) || $anterior < 1 || $anterior > 100) return false;
        $existia = is_file($this->arquivo);
        $arquivo = @fopen($this->arquivo, 'c+');
        if (!$arquivo) return false;
        try {
            if (!flock($arquivo, LOCK_EX)) return false;
            $conteudo = stream_get_contents($arquivo);
            $dados = json_decode($conteudo, true);
            if (!is_array($dados)) $dados = array('fase' => !$existia ? 'inscricao' : 'encerrado');
            $atual = $dados['limite_projetos_votacao'] ?? 3;
            if ($atual !== $anterior) return false;
            $dados['limite_projetos_votacao'] = $limite;
            $novo = json_encode($dados) . "\n";
            rewind($arquivo);
            if (!ftruncate($arquivo, 0) || fwrite($arquivo, $novo) !== strlen($novo) || !fflush($arquivo)) {
                rewind($arquivo); ftruncate($arquivo, 0); fwrite($arquivo, $conteudo); fflush($arquivo);
                return false;
            }
            return true;
        } finally { fclose($arquivo); }
    }
}
