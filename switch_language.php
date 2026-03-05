<?php
session_start();

// Verifique se o idioma selecionado é válido
if (isset($_GET['lang']) && ($_GET['lang'] == 'en' || $_GET['lang'] == 'pt')) {
    $_SESSION['lang'] = $_GET['lang'];
}

// Redirecione de volta para a página anterior
header('Location: ' . $_SERVER['HTTP_REFERER']);

// Redirecione de volta para a página principal
//header('Location: index.php');
?>

