<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bjhp_model extends CI_Model
{
    private $connection;

    private function connection()
    {
        if (!$this->connection) {
            // Reutiliza a conexão do portal (web_site), sem duplicar credenciais.
            $this->connection = $this->load->database('default', true);
            $this->connection->db_debug = false;
            if (!$this->connection->conn_id) throw new RuntimeException('Banco BJHP indisponível.');
        }
        return $this->connection;
    }

    private function query($sql, $values = array())
    {
        $result = $this->connection()->query($sql, $values);
        if ($result === false) throw new RuntimeException('Falha ao acessar o banco BJHP. Verifique a instalação das tabelas.');
        return $result;
    }

    public function ultimo()
    {
        return $this->query('SELECT * FROM bjhp_importacoes ORDER BY id DESC LIMIT 1')->row_array();
    }

    public function importar($api, $usuario)
    {
        $db = $this->connection();
        $lock = $this->query("SELECT GET_LOCK('bjhp_importacao', 0) AS acquired")->row_array();
        if ((int) $lock['acquired'] !== 1) throw new RuntimeException('Já existe uma importação em andamento. Aguarde.');
        $transaction = false;
        try {
            $data = $api->fetch();
            if (!$db->trans_begin()) throw new RuntimeException('Não foi possível iniciar a transação.');
            $transaction = true;
            $issues = array();
            foreach ($data['edicoes'] as $row) {
                $issues[$row['ojs_issue_id']] = $this->persistir('bjhp_edicoes', 'ojs_issue_id', $row);
            }
            foreach ($data['artigos'] as $row) {
                $issue = $row['edicao_ojs_id'];
                unset($row['edicao_ojs_id']);
                if (!isset($issues[$issue])) throw new RuntimeException('Artigo sem edição publicada correspondente. Tente novamente.');
                $row['edicao_id'] = $issues[$issue];
                $this->persistir('bjhp_artigos', 'ojs_article_id', $row);
            }
            $this->query('INSERT INTO bjhp_importacoes (usuario_id, usuario_nome, artigos, edicoes) VALUES (?, ?, ?, ?)',
                array((int) $usuario['id'], $usuario['nome'] ?? $usuario['login'], count($data['artigos']), count($data['edicoes'])));
            $history = $this->ultimo();
            if (!$db->trans_status() || !$db->trans_commit()) throw new RuntimeException('Não foi possível concluir a importação.');
            $transaction = false;
            return $history;
        } finally {
            if ($transaction) $db->trans_rollback();
            $db->query("SELECT RELEASE_LOCK('bjhp_importacao')");
        }
    }

    // As tabelas existentes não possuem UNIQUE/AUTO_INCREMENT. O lock da importação
    // serializa a alocação dos IDs; IDs locais existentes são preservados.
    private function persistir($table, $key, $row)
    {
        $existing = $this->query('SELECT id FROM `' . $table . '` WHERE `' . $key . '` = ? FOR UPDATE', array($row[$key]))->result_array();
        if (count($existing) > 1) throw new RuntimeException('Existem IDs OJS duplicados em ' . $table . '. Corrija antes de importar.');
        $row['sincronizado_em'] = date('Y-m-d H:i:s');
        $row['atualizado_em'] = $row['sincronizado_em'];
        if ($existing) {
            $id = (int) $existing[0]['id'];
            $columns = array();
            foreach (array_keys($row) as $column) $columns[] = '`' . $column . '` = ?';
            $values = array_values($row); $values[] = $row[$key];
            $this->query('UPDATE `' . $table . '` SET ' . implode(',', $columns) . ' WHERE `' . $key . '` = ?', $values);
        } else {
            $next = $this->query('SELECT COALESCE(MAX(id), 0) + 1 AS next_id FROM `' . $table . '`')->row_array();
            $id = (int) $next['next_id'];
            $row['id'] = $id;
            $this->query('INSERT INTO `' . $table . '` (`' . implode('`,`', array_keys($row)) . '`) VALUES (' .
                implode(',', array_fill(0, count($row), '?')) . ')', array_values($row));
        }
        return $id;
    }

    public function edicoes() { return $this->query('SELECT id, titulo, identificacao FROM bjhp_edicoes ORDER BY data_publicacao DESC, id DESC')->result_array(); }

    public function categorias_editorial()
    {
        return array('editor_chefe' => 'Editor-chefe', 'editor_associado' => 'Editor associado',
            'conselho_consultivo_editorial' => 'Conselho consultivo editorial',
            'tecnologia_da_informacao' => 'Tecnologia da informação', 'design' => 'Design',
            'comunicacao' => 'Comunicação', 'secretaria_administrativa' => 'Secretaria administrativa');
    }

    public function listar_corpo_editorial()
    {
        return $this->query('SELECT id, categoria, nome, foto, titulacao, instituicao, cidade, estado, pais, email, ordem_exibicao, status FROM `bjhp_corpo-editorial` ORDER BY ordem_exibicao ASC, nome ASC, id ASC')->result_array();
    }

    public function obter_editorial($id)
    {
        return $this->query('SELECT id, categoria, nome, titulacao, instituicao, cidade, estado, pais, orcid_url, foto, mini_curriculo, email, ordem_exibicao, status FROM `bjhp_corpo-editorial` WHERE id = ? LIMIT 1', array($id))->row_array();
    }

    public function atualizar_editorial($id, array $dados)
    {
        $db = $this->connection();
        if (!$db->trans_begin()) throw new RuntimeException('Não foi possível iniciar a edição.');
        $committed = false;
        try {
            $existing = $this->query('SELECT id FROM `bjhp_corpo-editorial` WHERE id = ? FOR UPDATE', array($id))->row_array();
            if (!$existing) throw new RuntimeException('Membro do corpo editorial não encontrado.');
            $dados['atualizado_em'] = date('Y-m-d H:i:s');
            $columns = array();
            foreach (array_keys($dados) as $column) $columns[] = '`' . $column . '` = ?';
            $values = array_values($dados);
            $values[] = $id;
            $this->query('UPDATE `bjhp_corpo-editorial` SET ' . implode(', ', $columns) . ' WHERE id = ?', $values);
            if (!$db->trans_status() || !$db->trans_commit()) throw new RuntimeException('Não foi possível salvar a edição.');
            $committed = true;
        } finally {
            if (!$committed) $db->trans_rollback();
        }
    }

    public function salvar_editorial(array $dados)
    {
        $db = $this->connection();
        $lock = $this->query("SELECT GET_LOCK('bjhp_corpo_editorial_cadastro', 0) AS acquired")->row_array();
        if ((int) $lock['acquired'] !== 1) throw new RuntimeException('Outro cadastro está em andamento. Tente novamente.');
        $transaction = false;
        try {
            if (!$db->trans_begin()) throw new RuntimeException('Não foi possível iniciar o cadastro.');
            $transaction = true;
            // A tabela existente não possui AUTO_INCREMENT. Serializa a geração do ID.
            $next = $this->query('SELECT COALESCE(MAX(id), 0) + 1 AS next_id FROM `bjhp_corpo-editorial`')->row_array();
            $dados['id'] = (int) $next['next_id'];
            $dados['criado_em'] = date('Y-m-d H:i:s');
            $dados['atualizado_em'] = $dados['criado_em'];
            $this->query('INSERT INTO `bjhp_corpo-editorial` (`' . implode('`,`', array_keys($dados)) . '`) VALUES (' .
                implode(',', array_fill(0, count($dados), '?')) . ')', array_values($dados));
            if (!$db->trans_status() || !$db->trans_commit()) throw new RuntimeException('Não foi possível concluir o cadastro.');
            $transaction = false;
        } finally {
            if ($transaction) $db->trans_rollback();
            $db->query("SELECT RELEASE_LOCK('bjhp_corpo_editorial_cadastro')");
        }
    }
}
