<?php
session_start();

// Defina o idioma padrão
$default_lang = 'en';

// Verifique se o idioma está definido na sessão, caso contrário, use o padrão
$lang = isset($_SESSION['lang']) ? $_SESSION['lang'] : $default_lang;

echo $lang;

// Inclua o arquivo de idioma apropriado
require_once "lang/$lang.php";
?>

<!DOCTYPE html>
<html lang="<?php echo $lang; ?>">
<head>
    <meta charset="UTF-8">
    <title>Multi-language Website</title>
</head>
<body>

<h1><?php echo $content['welcome']; ?></h1>

<nav>
    <ul>
        <?php foreach ($content['nav']['itens'] as $item): ?>
            <li><a href="<?php echo $item['link']; ?>"><?php echo $item['name']; ?></a></li>
        <?php endforeach; ?>
    </ul>
</nav>

<section>
    <h2><?php echo $content['services']['title']; ?></h2>
    <p><?php echo $content['services']['description']; ?></p>
</section>

<section>
    <h2><?php echo $content['team']['title']; ?></h2>
    <ul>
        <?php foreach ($content['team']['members'] as $member): ?>
            <li><?php echo $member['name']; ?> - <?php echo $member['position']; ?></li>
        <?php endforeach; ?>
    </ul>
</section>

<!-- Interface de troca de idioma -->
<select id="language-select">
    <option value="en" <?php echo $lang == 'en' ? 'selected' : ''; ?>>English</option>
    <option value="pt" <?php echo $lang == 'pt' ? 'selected' : ''; ?>>Português</option>
</select>

<script>
    // JavaScript para trocar o idioma
    document.getElementById('language-select').addEventListener('change', function() {
        var lang = this.value;
        window.location.href = 'switch_language.php?lang=' + lang;
    });
</script>

<div>
    <a href="switch_language.php?lang=en">English</a> |
    <a href="switch_language.php?lang=pt">Português</a>
</div>

</body>
</html>
