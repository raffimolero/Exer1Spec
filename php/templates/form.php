<h1><?= $heading ?></h1>
<form
    name="<?= $name ?>"
    action="<?= "$page/submit.php" ?>"
    <?php if ($validate) : ?> onsubmit="return validate()" <?php endif; ?>
    method="post">
    <br>
    <table>
        <?php foreach ($fields as [$label, $id, $type, $placeholder, $example]) : ?>
            <tr>
                <td><label for="<?= $id ?>"><?= $label ?>: </label></td>
                <td>
                    <input
                        id="<?= $id ?>"
                        name="<?= $id ?>"
                        type="<?= $type ?>"
                        placeholder="<?= $placeholder ?>"
                        <?php if ($id === 'email') : ?> embed="cookie" <?php endif; ?>>
                </td>
                <td><?= $example ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
    <br>
    <input type="submit" name="<?= $name ?>" id="submit" value="<?= $submit ?>">
    <?php if ($validate) : ?>
        <?= view('js', [
            'script' => $script,
            'path' => "$page/script.js"
        ]) ?>
    <?php endif; ?>

</form>