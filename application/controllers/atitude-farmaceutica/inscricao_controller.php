<?php

require_once __DIR__ . '/../models/InscricaoModel.php';

class InscricaoController {
    private $model;

    public function __construct($dbConnection) {
        $this->model = new InscricaoModel($dbConnection);
    }

    /**
     * Exibe a página do formulário
     */
    public function index() {
        require_once __DIR__ . '/../views/inscricao.php';
    }

    /**
     * Processa a submissão do formulário via AJAX/POST
     */
    public function processar() {
        header('Content-Type: application/json');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['status' => false, 'message' => 'Método não permitido.']);
            return;
        }

        // Validação básica dos campos obrigatórios
        $erros = $this->validarDados($_POST);
        if (!empty($erros)) {
            echo json_encode(['status' => false, 'erros' => $erros]);
            return;
        }

        // Upload de Imagens
        $imagensSalvas = [];
        if (isset($_FILES['imagens']) && !empty($_FILES['imagens']['name'][0])) {
            $diretorioDestino = __DIR__ . '/../uploads/projetos/';
            if (!is_dir($diretorioDestino)) {
                mkdir($diretorioDestino, 0755, true);
            }

            foreach ($_FILES['imagens']['name'] as $key => $name) {
                if ($_FILES['imagens']['error'][$key] === UPLOAD_ERR_OK) {
                    $extensao = strtolower(pathinfo($name, PATHINFO_EXTENSION));
                    if (in_array($extensao, ['jpg', 'jpeg', 'png', 'webp'])) {
                        $novoNome = uniqid('img_', true) . '.' . $extensao;
                        $caminhoCompleto = $diretorioDestino . $novoNome;

                        if (move_uploaded_file($_FILES['imagens']['tmp_name'][$key], $caminhoCompleto)) {
                            $imagensSalvas[] = 'uploads/projetos/' . $novoNome;
                        }
                    }
                }
            }
        }

        if (empty($imagensSalvas)) {
            echo json_encode(['status' => false, 'message' => 'Envie pelo menos uma imagem válida para o projeto.']);
            return;
        }

        $imagemPrincipal = $_POST['imagem_principal_idx'] ?? 0;

        // Salvar no Banco
        $resultado = $this->model->salvarInscricao($_POST, $imagensSalvas, (int)$imagemPrincipal);

        if ($resultado['status']) {
            echo json_encode(['status' => true, 'message' => 'Inscrição realizada com sucesso!']);
        } else {
            echo json_encode(['status' => false, 'message' => 'Erro ao salvar inscrição: ' . $resultado['error']]);
        }
    }

    private function validarDados($dados) {
        $erros = [];
        if (empty($dados['cpf'])) $erros[] = 'CPF é obrigatório.';
        if (empty($dados['celular'])) $erros[] = 'Celular é obrigatório.';
        if (empty($dados['telefone'])) $erros[] = 'Telefone é obrigatório.';
        if (empty($dados['cidade_farmaceutico'])) $erros[] = 'Cidade do farmacêutico é obrigatória.';
        
        if (empty($dados['nome_projeto'])) $erros[] = 'Nome do projeto é obrigatório.';
        if (empty($dados['eixo_projeto'])) $erros[] = 'Eixo do projeto é obrigatório.';
        if (empty($dados['numero_pessoas'])) $erros[] = 'Número de pessoas é obrigatório.';
        if (empty($dados['cidade_projeto'])) $erros[] = 'Cidade de realização do projeto é obrigatória.';
        if (empty($dados['local_projeto'])) $erros[] = 'Local de realização é obrigatório.';
        if (empty($dados['data_inicio'])) $erros[] = 'Data de início é obrigatória.';
        if (empty($dados['recursos'])) $erros[] = 'Recursos são obrigatórios.';
        if (empty($dados['descricao_projeto'])) $erros[] = 'Descrição é obrigatória.';
        if (empty($dados['justificativa'])) $erros[] = 'Justificativa é obrigatória.';
        if (empty($dados['beneficios_alcancados'])) $erros[] = 'Benefícios alcançados são obrigatórios.';
        if (empty($dados['objetivos_alcancados'])) $erros[] = 'Objetivos já alcançados são obrigatórios.';

        if (!isset($dados['aceite_termos'])) $erros[] = 'Você deve aceitar os termos e condições.';

        return $erros;
    }
}