<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/init.php'; ?>

<?php ob_start(); ?>
<form name=<?= $name ?> action=<?= "/controllers/" . $path . "/submit.php" ?> onsubmit="return validate()" method="post">
    <?php foreach ($fields as $key => $val) : ?>
        <label for=<?= $key ?>>Name: </label>
        <input
            type=<?= $val['type'] ?>
            name=<?= $key ?>
            id=<?= $key ?>
            placeholder=<?= $val['format'] ?>
            pattern=<?= $val['pattern'] ?>
            title=<?= $val['title'] ?>
            onblur=<?= $val['validate'] ?>
            required />
        <br />
    <?php endforeach; ?>
    <input type="submit" name=<?= $name ?> id="submit" value=$title />
</form>
<script src=<?= "/controllers/" . $path . "/script.js" ?>></script>
<!--
TODO: automatically generate a script src if one is found in the correct controllers folder?
'script' => 'validate.js',
-->
<?php $body = ob_get_clean(); ?>

<?= render('template', [
    'body' => $body,
])
?>