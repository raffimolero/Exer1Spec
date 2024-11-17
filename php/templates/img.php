<?php
$asset = ASSETS . "/$name.jpeg";
// HACK
// download_image($url, $asset);
?>

<img src="<?= $asset ?>" alt="(image of <?= $name ?>)">