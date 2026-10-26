<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Certificados extends MY_Controller
{
    private function curso($id)
    {
        if (!ctype_digit((string) $id) || (int) $id < 1) { show_404(); return null; }
        $curso = $this->db->where('courseid', (int) $id)->get('tbl_portalfarma')->row();
        if (!$curso) { show_404(); return null; }
        return $curso;
    }

    public function index($id = null)
    {
        $curso = $this->curso($id);
        if (!$curso) return;
        $this->carregarCabecalho();
        $this->load->view('certificados', ['curso' => $curso]);
        $this->load->view('fixo/rodape');
    }

    public function baixar($id = null)
    {
        if ($this->input->method() !== 'post') { show_error('Método não permitido.', 405); return; }
        $curso = $this->curso($id);
        if (!$curso) return;
        $this->load->helper('certificados');
        $cpf = $this->input->post('cpf');
        if (!is_string($cpf) || !certificados_cpf_valido($cpf)) {
            return $this->erro('Informe um CPF válido.', 422);
        }
        $cpf = preg_replace('/\D/', '', $cpf);
        $this->load->model('Certificados_model');
        try {
            $participante = $this->Certificados_model->participante_concluinte($curso, $cpf);
        } catch (Throwable $error) {
            log_message('error', 'Falha ao consultar conclusão para certificado do curso ' . (int) $id);
            return $this->erro('O serviço de confirmação de participação está indisponível. Tente novamente mais tarde.', 503);
        }
        if (!$participante) {
            if (in_array((int) $curso->tipo_evento, [1, 2], true)) {
                return $this->erro('Certificado indisponível: confira se o CPF está vinculado a uma matrícula ativa neste curso no Moodle e se a presença ou conclusão foi confirmada.', 422);
            }
            return $this->erro('Certificado indisponível: confira o CPF e se a presença ou conclusão deste curso foi confirmada.', 422);
        }
        if (in_array((int) $curso->tipo_evento, [1, 2], true)) {
            try {
                $palestrantes = $this->Certificados_model->palestrantes_curso($id);
                $this->load->library('Certificado_capacifar');
                $conteudo = $this->certificado_capacifar->gerar($curso, $participante, $palestrantes);
            } catch (Throwable $error) {
                log_message('error', 'Falha ao gerar certificado Capacifar do curso ' . (int) $id);
                return $this->erro('Não foi possível preparar o certificado. Tente novamente mais tarde.', 503);
            }
            $this->output->set_content_type('application/pdf')->set_header('Cache-Control: no-store')
                ->set_header('Content-Disposition: attachment; filename="certificado-' . (int) $id . '.pdf"')
                ->set_output($conteudo);
            return;
        }
        require_once FCPATH . 'vendor/autoload.php';
        $pdf = new TCPDF('L', 'mm', 'A4', true, 'UTF-8');
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->SetMargins(25, 25, 25);
        $pdf->SetAutoPageBreak(true, 25);
        $pdf->SetTitle('Certificado - ' . $curso->titulo);
        $pdf->AddPage();
        $pdf->SetDrawColor(0, 89, 141);
        $pdf->Rect(12, 12, 273, 186);
        $pdf->SetTextColor(18, 69, 94);
        $pdf->SetFont('dejavusans', '', 16);
        $escape = function ($value) { return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8'); };
        $carga = isset($curso->carga_horaria) ? (int) $curso->carga_horaria : 0;
        $html = '<h2 style="text-align:center">Portal Farma • CRF/MG</h2>'
            . '<h1 style="text-align:center">CERTIFICADO</h1><p>Certificamos que <strong>'
            . $escape($participante->nome) . '</strong> concluiu o curso <strong>'
            . $escape($curso->titulo) . '</strong>'
            . ($carga > 0 ? ', com carga horária de ' . floor($carga / 60) . 'h ' . ($carga % 60) . 'min' : '')
            . '.</p><p style="text-align:center">Emitido em ' . date('d/m/Y') . '.</p>';
        $pdf->writeHTML($html);
        $this->output->set_content_type('application/pdf')
            ->set_header('Cache-Control: no-store')
            ->set_header('Content-Disposition: attachment; filename="certificado-' . (int) $id . '.pdf"')
            ->set_output($pdf->Output('', 'S'));
    }

    private function erro($mensagem, $status)
    {
        $this->output->set_status_header($status)->set_content_type('application/json')
            ->set_output(json_encode(['message' => $mensagem]));
    }
}
