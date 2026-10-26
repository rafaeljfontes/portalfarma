<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Certificados_model extends CI_Model
{
    public function participante_concluinte($curso, $cpf)
    {
        $locais = [3 => ['urm_inscricao', 'urm_evento'], 4 => ['fiscalizacao_humanizada_inscricao', 'id_evento'], 7 => ['tbl_seminario_inscricao', 'seminario']];
        $tipo = (int) $curso->tipo_evento;
        if (isset($locais[$tipo])) {
            list($tabela, $campo) = $locais[$tipo];
            return $this->db->select('nome')->where($campo, $curso->courseid)->where('presenca', 1)
                ->where("REPLACE(REPLACE(REPLACE(cpf, '.', ''), '-', ''), ' ', '') =", $cpf)
                ->get($tabela)->row();
        }
        if (!in_array($tipo, [1, 2], true)) return null;
        $presencial = $tipo === 1;
        // Só há linhas nesta tabela para participantes marcados como presentes.
        if ($presencial && !$this->db->where('courseid', (int) $curso->courseid)
            ->count_all_results('web_site.tbl_portalfarma_presenca')) return null;
        $moodle = $this->load->database('moodle', true);
        $moodle->select("u.id AS id_moodle, CONCAT(u.firstname, ' ', u.lastname) AS nome", false)
            ->from('mdl_user u')->join('mdl_user_enrolments ue', 'ue.userid = u.id')
            ->join('mdl_enrol e', 'e.id = ue.enrolid')
            ->where('e.courseid', (int) $curso->courseid)->where('u.username', $cpf)
            ->where('u.deleted', 0)->where('u.suspended', 0)->where('ue.status', 0);
        // Presencial usa a presença local; online mantém a conclusão no Moodle.
        if (!$presencial) {
            $moodle->join('mdl_course_completions cc', 'cc.userid = u.id AND cc.course = e.courseid')
                ->where('cc.timecompleted >', 0);
        }
        $participante = $moodle->limit(1)->get()->row();
        if (!$participante) return null;
        if ($presencial && !$this->db->where('courseid', (int) $curso->courseid)
            ->where('id_moodle', (int) $participante->id_moodle)
            ->count_all_results('web_site.tbl_portalfarma_presenca')) return null;
        return $participante;
    }

    public function palestrantes_curso($courseid)
    {
        return $this->db->select('p.nome')->distinct()
            ->from('tbl_portalfarma_palestrantes p')
            ->join('tbl_portalfarma_palestrantes_curso pc', 'pc.id_palestrante = p.id_palestrante')
            ->where('pc.courseid', (int) $courseid)->order_by('p.nome', 'ASC')->get()->result();
    }
}
