<?php
$asset = ASSETS . "/$name.jpeg";
download_image($url, $asset);
?>

<img src="<?= $asset ?>" alt="(image of <?= $name ?>)">