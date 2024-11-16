<!DOCTYPE html>
<h1>$heading</h1>
<?php foreach ($links as [$href, $text]) : ?>
    <a href="/views/<?= $href ?>.html">
        <p><?= $text ?></p>
    </a>
<?php endforeach; ?>