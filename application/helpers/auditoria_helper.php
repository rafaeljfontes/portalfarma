<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('registrar_historico')) {
    /**
     * Registra uma ação realizada na área restrita.
     *
     * @param int $idAcao    ID existente em tbl_portalfarma_auditoria_acoes.
     * @param int $idRegistro ID primário do registro criado ou alterado.
     * @return bool
     */
    function registrar_historico($idAcao, $idRegistro, &$erro = null)
    {
        $erro = null;
        $CI =& get_instance();
        $CI->load->database();

		// Uma falha na auditoria não pode invalidar a operação principal já salva.
		$dbDebugOriginal = $CI->db->db_debug;
		$CI->db->db_debug = false;
		$nivelBufferOriginal = ob_get_level();
		ob_start();

		try {
			if (!$CI->db->table_exists('tbl_portalfarma_historico')
				|| !$CI->db->table_exists('tbl_portalfarma_auditoria_acoes')
				|| !$CI->db->table_exists('tbl_portalfarma_user')) {
				log_message('error', 'Auditoria não registrada: estrutura de tabelas não instalada.');
				$erro = 'As tabelas necessárias para registrar o histórico não estão instaladas.';
				return false;
			}

			$idAcao = (int) $idAcao;
			$idRegistro = (int) $idRegistro;
			if ($idAcao <= 0 || $idRegistro <= 0) {
				log_message('error', 'Auditoria não registrada: ação ou registro inválido.');
				$erro = 'A ação ou o registro informado para o histórico é inválido.';
				return false;
			}

        $usuarioLogado = (array) $CI->session->userdata('usuario_logado');
        $idUsuario = (int) ($usuarioLogado['id'] ?? 0);

        // Compatibilidade com sessões abertas antes da inclusão do ID do usuário.
        $login = $usuarioLogado['login'] ?? ($usuarioLogado['usuario'] ?? '');
        if ($idUsuario <= 0 && $login !== '') {
            $usuario = $CI->db
                ->select('id')
                ->where('user', $login)
                ->limit(1)
                ->get('tbl_portalfarma_user')
                ->row();
            $idUsuario = $usuario ? (int) $usuario->id : 0;
        }

        if ($idUsuario <= 0) {
            log_message('error', 'Auditoria não registrada: usuário da sessão não localizado.');
            $erro = 'O usuário da sessão não foi localizado para registrar o histórico.';
            return false;
        }

        $acaoExiste = $CI->db
            ->where('id', $idAcao)
            ->count_all_results('tbl_portalfarma_auditoria_acoes') > 0;
        if (!$acaoExiste) {
            log_message('error', 'Auditoria não registrada: ação #' . $idAcao . ' não existe.');
            $erro = 'A ação de auditoria #' . $idAcao . ' não está cadastrada.';
            return false;
        }

        $agora = new DateTimeImmutable('now', new DateTimeZone('America/Sao_Paulo'));

        $salvou = $CI->db->insert('tbl_portalfarma_historico', [
            'id_acao' => $idAcao,
            'id_usuario' => $idUsuario,
            'id_registro' => $idRegistro,
            'data_hora' => $agora->format('Y-m-d H:i:s'),
        ]);

        if (!$salvou) {
            log_message('error', 'Falha ao registrar auditoria da ação #' . $idAcao . '.');
            $erro = 'Não foi possível gravar o histórico no banco de dados. Consulte o log do servidor.';
        }

			return (bool) $salvou;
		} catch (Throwable $e) {
			log_message('error', 'Falha ao registrar auditoria: ' . $e->getMessage());
			$erro = 'Ocorreu uma falha ao registrar o histórico. Consulte o log do servidor.';
			return false;
		} finally {
			// Descarta qualquer aviso/saida produzido exclusivamente pela auditoria.
			while (ob_get_level() > $nivelBufferOriginal) {
				ob_end_clean();
			}
			$CI->db->db_debug = $dbDebugOriginal;
		}
    }
}
