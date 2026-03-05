<?php
session_start();

// idiomas permitidos
$allowed = ['pt', 'en'];

// pega ?lang=
$lang = isset($_GET['lang']) ? strtolower(trim($_GET['lang'])) : 'pt';
if (!in_array($lang, $allowed, true)) {
  $lang = 'pt';
}

// salva na sessão
$_SESSION['lang'] = $lang;

/**
 * volta para a página anterior (referrer) se for do mesmo site,
 * senão volta para a home
 */
$defaultRedirect = '/';

$ref = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';
$host = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '';

if ($ref && $host && strpos($ref, $host) !== false) {
  header("Location: $ref", true, 302);
  exit;
}

header("Location: $defaultRedirect", true, 302);
exit;
?>