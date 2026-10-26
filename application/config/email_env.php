<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$envArquivo = dirname(__DIR__, 2) . '/.env';
if (is_readable($envArquivo)) {
    foreach (file($envArquivo, FILE_IGNORE_NEW_LINES) as $envLinha) {
        $envLinha = trim($envLinha);
        if ($envLinha === '' || $envLinha[0] === '#' || strpos($envLinha, '=') === false) continue;
        list($envChave, $envValor) = explode('=', $envLinha, 2);
        $envChave = trim($envChave);
        if (!preg_match('/^MAIL_[A-Z_]+$/', $envChave) || getenv($envChave) !== false) continue;
        $envValor = trim($envValor);
        if (strlen($envValor) >= 2 && (($envValor[0] === '"' && substr($envValor, -1) === '"') || ($envValor[0] === "'" && substr($envValor, -1) === "'"))) $envValor = substr($envValor, 1, -1);
        putenv($envChave . '=' . $envValor);
    }
}
$config['portal_transport'] = getenv('PORTALFARMA_EMAIL_TRANSPORT') ?: 'direto';
$config['protocol'] = getenv('MAIL_MAILER') ?: 'smtp';
$config['smtp_host'] = getenv('MAIL_HOST') ?: 'smtp.gmail.com';
$config['smtp_user'] = getenv('MAIL_USERNAME') ?: '';
$config['smtp_pass'] = getenv('MAIL_PASSWORD') ?: '';
$config['smtp_port'] = (int) (getenv('MAIL_PORT') ?: 587);
$config['smtp_crypto'] = getenv('MAIL_ENCRYPTION') ?: 'tls';
$config['mailtype'] = 'html';
$config['charset'] = 'utf-8';
$config['wordwrap'] = true;
$config['smtp_timeout'] = 15;
$config['newline'] = "\r\n";
$config['crlf'] = "\r\n";
