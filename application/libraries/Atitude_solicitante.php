<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Atitude_solicitante
{
    const NAO_ENCONTRADO = 'Não foram encontrados dados na base de dados do CRF/MG. Não será possível realizar a inscrição.';

    public function extrair($resposta, $tipo)
    {
        if (!in_array($tipo, array('farmaceutico', 'empresa'), true) || !is_array($resposta)) return null;
        $raiz = isset($resposta['type']) ? $resposta : ($resposta[0] ?? array());
        if (!is_array($raiz) || !isset($raiz['type']) || !is_string($raiz['type']) || strtolower($raiz['type']) !== 'success') return null;
        $fila = array(array($resposta, 0));
        $chaveNome = $tipo === 'empresa' ? 'RazaoSocial' : 'Nome';
        while ($fila) {
            list($dados, $nivel) = array_shift($fila);
            $nome = $dados[$chaveNome] ?? ($tipo === 'farmaceutico' ? ($dados['NomePF'] ?? null) : null);
            $cidade = $dados['Cidade'] ?? (isset($dados['NomePF']) && $tipo === 'farmaceutico' ? '' : null);
            if (is_string($nome) && trim($nome) !== '' && is_string($cidade) && mb_strlen($nome, 'UTF-8') <= 255 && mb_strlen($cidade, 'UTF-8') <= 150 && (trim($cidade) !== '' || isset($dados['NomePF']))) {
                return array('tipo' => $tipo, 'nome' => trim($nome), 'cidade' => trim($cidade));
            }
            if ($nivel >= 3) continue;
            foreach ($dados as $valor) if (is_array($valor)) $fila[] = array($valor, $nivel + 1);
        }
        return null;
    }

    public function confirmado($verificado, $tipo, $registro)
    {
        return is_array($verificado) && is_string($tipo) && is_string($registro)
            && in_array($tipo, array('farmaceutico', 'empresa'), true)
            && preg_match('/\A[0-9]{1,50}\z/', trim($registro)) === 1
            && ($verificado['tipo'] ?? null) === $tipo && ($verificado['registro'] ?? null) === trim($registro)
            && isset($verificado['nome'], $verificado['cidade'])
            && is_string($verificado['nome']) && trim($verificado['nome']) !== ''
            && is_string($verificado['cidade']);
    }
}
