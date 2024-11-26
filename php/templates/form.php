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
                <td><input
                        id="<?= $id ?>"
                        name="<?= $id ?>"
                        type="<?= $type ?>"
                        placeholder="<?= $placeholder ?>"></td>
                <td><?= $example ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
    <br>
    <input type="submit" name="<?= $name ?>" id="submit" value="<?= $submit ?>">
    <?php if ($validate) : ?>
        <?php
        // TODO: cleanup
        $script = preg_replace("/    (.*)((\r?\n)|(\r\n?))/", '${1}${2}', $script);
        $script = preg_replace('/<\/?script>/', '', $script);
        $dest = DEST . '/' . $page . "/script.js";
        file_put_contents($dest, $script);
        `prettier --config .prettierrc --write $dest`;
        ?>
        <script src="<?= "$page/script.js" ?>"></script>
    <?php endif; ?>
</form>