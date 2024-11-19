<h1><?= $heading ?></h1>
<form
    name="<?= $name ?>"
    action="<?= "$page/submit.php" ?>"
    <?php if ($validate) : ?> onsubmit="return validate()" <?php endif; ?>
    method="post">
    <?php foreach ($fields as [$label, $id, $type, $placeholder, $example]) : ?>
        <label for="<?= $id ?>"><?= $label ?>: </label>
        <input
            id="<?= $id ?>"
            name="<?= $id ?>"
            type="<?= $type ?>"
            placeholder="<?= $placeholder ?>">
        <?= $example ?>
        <br>
    <?php endforeach; ?>
    <input type="submit" name="<?= $name ?>" id="submit" value="<?= $submit ?>">
    <?php if ($validate) : ?><?= $script ?><?php endif; ?>
</form>
