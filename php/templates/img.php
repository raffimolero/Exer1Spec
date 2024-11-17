<?php
$asset = ASSETS . "/$name.jpeg";
download_image($url, $asset);
?>

<img src="<?= "$root/$asset" ?>" alt="(image of <?= $name ?>)">