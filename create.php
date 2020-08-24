<?php

$template = null;
if (array_key_exists('template', $_POST)) {
    $template = $_POST['template'];
}

if (!$template || !file_exists('./templates/' . $template)) {
    die('Vorlage nicht gefunden!');
}

// template laden
$templateHtml = file_get_contents('./templates/' . $template);

// Inhalte ersetzen
$vars = [];
preg_match_all('/%.*%/', $templateHtml, $vars);
$vars = !empty($vars) ? $vars[0] : $vars;
foreach ($vars as $var) {
    $templateHtml  = str_replace($var, $_POST[$var], $templateHtml);
}

// speichern
file_put_contents('./build/' . $template, $templateHtml);

?>

<html>

<head>
    <title>Erfolg</title>
</head>

<body>
    <h1>Datei erstellt!</h1>
    <a href="index.php">Zurück</a>

    <hr>

    <iframe style="width: 100%; height: 100%;" src="./build/<?= $template ?>"></iframe>
</body>

</html>
