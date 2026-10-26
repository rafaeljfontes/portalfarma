<?php

class InscricaoModel {
    private $db;

    public function __construct($databaseConnection) {
        $this->db = $databaseConnection;
    }

    /**
     * Salva uma nova inscrição no banco de dados.
     */
    public function salvarInscricao(array $dados, array $imagens, ?int $imagemPrincipalIndex = 0) {
        try {
            $this->db->beginTransaction();

            // 1. Inserir dados do Farmacêutico Responsável
            $sqlFarmaceutico = "INSERT INTO farmaceuticos (cpf, numero_crf, email, celular, telefone, cidade, criado_em) 
                                VALUES (:cpf, :numero_crf, :email, :celular, :telefone, :cidade, NOW())";
            $stmtF = $this->db->prepare($sqlFarmaceutico);
            $stmtF->execute([
                ':cpf'        => preg_replace('/[^0-9]/', '', $dados['cpf']),
                ':numero_crf' => $dados['numero_crf'] ?? null,
                ':email'      => $dados['email'] ?? null,
                ':celular'    => $dados['celular'],
                ':telefone'   => $dados['telefone'],
                ':cidade'     => $dados['cidade_farmaceutico']
            ]);
            $farmaceuticoId = $this->db->lastInsertId();

            // 2. Inserir dados do Projeto
            $sqlProjeto = "INSERT INTO projetos (
                farmaceutico_id, nome_projeto, eixo_projeto, numero_pessoas, cidade_realizacao, 
                local_realizacao, data_inicio, recursos_fonte, descricao, justificativa, 
                pessoas_alcancadas, beneficios_alcancados, objetivos_futuros, aceite_termos, criado_em
            ) VALUES (
                :farmaceutico_id, :nome_projeto, :eixo_projeto, :numero_pessoas, :cidade_realizacao, 
                :local_realizacao, :data_inicio, :recursos_fonte, :descricao, :justificativa, 
                :pessoas_alcancadas, :beneficios_alcancados, :objetivos_futuros, :aceite_termos, NOW()
            )";

            $stmtP = $this->db->prepare($sqlProjeto);
            $stmtP->execute([
                ':farmaceutico_id'      => $farmaceuticoId,
                ':nome_projeto'         => $dados['nome_projeto'],
                ':eixo_projeto'         => $dados['eixo_projeto'],
                ':numero_pessoas'       => $dados['numero_pessoas'],
                ':cidade_realizacao'    => $dados['cidade_projeto'],
                ':local_realizacao'     => $dados['local_projeto'],
                ':data_inicio'          => $dados['data_inicio'],
                ':recursos_fonte'       => $dados['recursos'],
                ':descricao'            => $dados['descricao_projeto'],
                ':justificativa'        => $dados['justificativa'],
                ':pessoas_alcancadas'   => $dados['pessoas_alcancadas'] ?? null,
                ':beneficios_alcancados'=> $dados['beneficios_alcancados'],
                ':objetivos_futuros'    => $dados['objetivos_alcancados'],
                ':aceite_termos'        => isset($dados['aceite_termos']) ? 1 : 0
            ]);
            $projetoId = $this->db->lastInsertId();

            // 3. Registrar Imagens do Projeto
            $sqlImagem = "INSERT INTO projeto_imagens (projeto_id, caminho_arquivo, eh_principal, criado_em) 
                          VALUES (:projeto_id, :caminho_arquivo, :eh_principal, NOW())";
            $stmtI = $this->db->prepare($sqlImagem);

            foreach ($imagens as $index => $caminho) {
                $ehPrincipal = ($index == $imagemPrincipalIndex) ? 1 : 0;
                $stmtI->execute([
                    ':projeto_id'      => $projetoId,
                    ':caminho_arquivo' => $caminho,
                    ':eh_principal'    => $ehPrincipal
                ]);
            }

            $this->db->commit();
            return ['status' => true, 'projeto_id' => $projetoId];

        } catch (PDOException $e) {
            $this->db->rollBack();
            return ['status' => false, 'error' => $e->getMessage()];
        }
    }
}