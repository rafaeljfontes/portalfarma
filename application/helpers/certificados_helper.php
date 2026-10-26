<?php
defined('BASEPATH') OR exit('No direct script access allowed');

function certificados_cpf_valido($cpf)
{
    if (!is_string($cpf) || !preg_match('/^(?:\d{11}|\d{3}\.\d{3}\.\d{3}-\d{2})$/D', $cpf)) return false;
    $cpf = preg_replace('/\D/', '', $cpf);
    if (preg_match('/^(\d)\1{10}$/', $cpf)) return false;
    for ($t = 9; $t < 11; $t++) {
        $soma = 0;
        for ($i = 0; $i < $t; $i++) $soma += (int) $cpf[$i] * ($t + 1 - $i);
        $digito = (10 * $soma) % 11;
        if ($digito === 10) $digito = 0;
        if ((int) $cpf[$t] !== $digito) return false;
    }
    return true;
}
