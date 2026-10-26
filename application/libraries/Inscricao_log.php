<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Inscricao_log
{
    public static $ativo;
    private $pasta;
    private $dados = [];
    private $id;
    private $confirmada = false;
    private $erros = [];
    private $finalizado = false;

    public function __construct($config = [])
    {
        $this->pasta = $config['pasta'] ?? APPPATH.'logs/inscricoes/';
    }

    public function iniciar(array $dados, $mensagem = null)
    {
        self::$ativo = $this;
        $this->id = bin2hex(random_bytes(12));
        // Dados cadastrais apenas: nunca registrar senhas, tokens ou o POST integral.
        $this->dados = array_intersect_key($dados, array_flip([
            'nome', 'cpf', 'email', 'cidade', 'crfmg', 'telefone', 'pais', 'country',
            'course_id', 'curso_titulo', 'campo_evento', 'publico_alvo'
        ]));
        $this->gravar(['evento'=>'inicio', 'resultado'=>'em_andamento']);
        register_shutdown_function(function () use ($mensagem) {
            $ultimoErro = error_get_last();
            if ($ultimoErro && in_array($ultimoErro['type'], [E_ERROR, E_PARSE, E_CORE_ERROR, E_COMPILE_ERROR, E_USER_ERROR], true)) {
                $this->erro('php', ['message'=>$ultimoErro['message']]);
            }
            $this->finalizar(is_callable($mensagem) ? $mensagem() : null);
        });
    }

    public function erro($etapa, array $erro)
    {
        $this->erros[] = ['etapa'=>$etapa] + array_intersect_key($erro, array_flip([
            'code', 'message', 'http_code', 'curl_errno', 'curl_error', 'debug'
        ]));
    }

    public function confirmar()
    {
        $this->confirmada = true;
    }

    public function finalizar($mensagem = null)
    {
        if ($this->finalizado) return;
        $this->finalizado = true;
        $this->gravar([
            'evento'=>'resultado', 'resultado'=>$this->confirmada ? 'sucesso' : 'erro',
            'inscrito_com_sucesso'=>$this->confirmada,
            'mensagem'=>$mensagem ?: ($this->confirmada ? 'Inscrição confirmada no Moodle.' : 'Inscrição não confirmada no Moodle.'),
            'erros'=>$this->erros
        ]);
    }

    private function gravar(array $evento)
    {
        $agora = new DateTimeImmutable('now', new DateTimeZone('America/Sao_Paulo'));
        $registro = ['data_hora'=>$agora->format('c'), 'tentativa'=>$this->id, 'dados'=>$this->dados] + $evento;
        if (!is_dir($this->pasta) && !@mkdir($this->pasta, 0700, true) && !is_dir($this->pasta)) {
            error_log('Não foi possível criar o diretório de logs de inscrições.');
            return;
        }
        $arquivo = rtrim($this->pasta, '/\\').'/inscricoes-'.$agora->format('Y-m-d').'.txt';
        $linha = json_encode($registro, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_INVALID_UTF8_SUBSTITUTE).PHP_EOL;
        if (@file_put_contents($arquivo, $linha, FILE_APPEND | LOCK_EX) === false) {
            error_log('Não foi possível gravar o log de inscrições.');
        }
    }
}
