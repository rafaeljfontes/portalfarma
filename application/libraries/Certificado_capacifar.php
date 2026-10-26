<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Certificado_capacifar
{
    public function gerar($curso, $participante, array $palestrantes = [])
    {
        require_once FCPATH . 'vendor/autoload.php';
        if (!in_array((int) $curso->tipo_evento, [1, 2], true)) {
            throw new InvalidArgumentException('Tipo de evento não suportado pelo certificado Capacifar.');
        }
        $modalidade = (int) $curso->tipo_evento === 1 ? 'presencial' : 'online';
        $fundo = FCPATH . 'public/Certificados/certificado-capacifar-2026_' . $modalidade . '.png';
        if (!is_readable($fundo)) throw new RuntimeException('Fundo do certificado indisponível.');
        $pdf = new TCPDF('L', 'mm', 'A4', true, 'UTF-8');
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->SetMargins(0, 0, 0);
        $pdf->SetAutoPageBreak(false, 0);
        $pdf->SetTitle('Certificado - ' . $curso->titulo);
        $pdf->AddPage();
        $pdf->Image($fundo, 0, 0, 297, 210, 'PNG');
        $pdf->SetTextColor(95, 100, 117);
        $this->texto($pdf, "O CONSELHO REGIONAL DE FARMÁCIA DO ESTADO DE MINAS GERAIS\ncertifica que", 52, 19, 17, true);
        $pdf->SetTextColor(237, 29, 64);
        $this->texto($pdf, mb_strtoupper($participante->nome, 'UTF-8'), 76, 18, 28, true);
        $pdf->SetTextColor(95, 100, 117);
        $texto = 'participou do curso “' . $curso->titulo . '”';
        $nomes = array_filter(array_map(function ($pessoa) { return trim($pessoa->nome); }, $palestrantes));
        if ($nomes) $texto .= ', ministrado por ' . implode(', ', $nomes);
        $minutos = isset($curso->carga_horaria) ? (int) $curso->carga_horaria : 0;
        if ($minutos > 0) {
            $horas = (int) floor($minutos / 60);
            $resto = $minutos % 60;
            $carga = $horas > 0 ? $horas . ($horas === 1 ? ' hora' : ' horas') : '';
            if ($resto) $carga .= ($horas ? ' e ' : '') . $resto . ($resto === 1 ? ' minuto' : ' minutos');
            $texto .= ', com carga horária de ' . $carga;
        }
        if (!empty($curso->local)) $texto .= ', realizado em ' . trim($curso->local);
        $this->texto($pdf, $texto . '.', 99, 23, 17, true);
        $data = !empty($curso->data_fim) ? strtotime($curso->data_fim) : false;
        if (!$data && !empty($curso->data_inicio)) $data = strtotime($curso->data_inicio);
        if ($data) {
            $meses = [1=>'janeiro', 'fevereiro', 'março', 'abril', 'maio', 'junho', 'julho', 'agosto', 'setembro', 'outubro', 'novembro', 'dezembro'];
            $this->texto($pdf, 'Belo Horizonte, ' . date('j', $data) . ' de ' . $meses[(int) date('n', $data)] . ' de ' . date('Y', $data), 125, 10, 16, false);
        }
        return $pdf->Output('', 'S');
    }

    private function texto($pdf, $texto, $y, $altura, $tamanho, $negrito)
    {
        // Reduzir textos extensos dentro da área livre, sem invadir assinatura/rodapé.
        $estilo = $negrito ? 'B' : '';
        do {
            $pdf->SetFont('dejavusans', $estilo, $tamanho);
            if ($pdf->getStringHeight(253, $texto) <= $altura) break;
            $tamanho -= 0.5;
        } while ($tamanho >= 9);
        if ($pdf->getStringHeight(253, $texto) > $altura) throw new RuntimeException('Texto excede a área do certificado.');
        $pdf->MultiCell(253, $altura, $texto, 0, 'C', false, 1, 22, $y, true, 0, false, true, $altura, 'M');
    }
}
