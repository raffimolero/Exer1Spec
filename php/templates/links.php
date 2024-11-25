<?php foreach ($links as [$text, $link]) : ?>
    <a href="<?= "$root/$link" ?>"><?= $text ?></a>
<?php endforeach; ?>