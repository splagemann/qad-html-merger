<?php

$templates = array_filter(scandir('./templates'), function ($dir) {
    return $dir !== '.' && $dir !== '..';
});

$template = null;
if (array_key_exists('template', $_GET) && $_GET['template'] !== '') {
    $template = $_GET['template'];
}

$vars = [];
if ($template) {
    $templateHtml = file_get_contents('./templates/' . $template);
    preg_match_all('/%.*%/', $templateHtml, $vars);
    $vars = !empty($vars) ? $vars[0] : $vars;
}

?>

<html>

<head>
    <title>Quick and Dirty HTML Merger</title>
</head>

<body>
    <h1>Vorlage anpassen</h1>
    <form>
        <label>Vorlage</label><br>
        <select name="template" onchange="this.form.submit();">
            <option value=''>Bitte auswählen</option>
            <?php foreach ($templates as $t) { ?>
                <option value='<?= $t ?>' <?= ($template === $t) ? 'selected' : '' ?>>
                    <?= str_replace('_', ' ', strtok($t, '.')); ?>
                </option>
            <?php } ?>
        </select>
    </form>

    <form action="create.php" method="POST">
        <input type="hidden" name='template' value="<?= $template ?>">

        <?php foreach ($vars as $var) { ?>
            <p>
                <label><?= str_replace('%', '', $var); ?></label><br>
                <input type="text" name="<?= $var ?>">
            </p>
        <?php } ?>

        <input type="submit" value="Abschicken">
    </form>

    <?php if ($template) { ?>
        <iframe style="width: 100%; height: 100%;" src="./build/<?= $template ?>"></iframe>
    <?php } ?>
</body>

</html>
