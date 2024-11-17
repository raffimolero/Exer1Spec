<h1><?= $heading ?></h1>
<form name="<?= $name ?>" action="<?= "$page/submit.php" ?>" onsubmit="return validate()" method="post">
    <?php foreach ($fields as [$label, $id, $type, $placeholder, $_requirements]) : ?>
        <label for="<?= $id ?>"><?= $label ?>: </label>
        <input
            id="<?= $id ?>"
            name="<?= $id ?>"
            type="<?= $type ?>"
            placeholder="<?= $placeholder ?>">
        <br>
    <?php endforeach; ?>
    <input type="submit" name="<?= $name ?>" id="submit" value="<?= $submit ?>">
    <?= $script ?>
</form>