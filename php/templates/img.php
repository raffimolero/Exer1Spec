<?php
$asset = download_image($url, $name);
?>

<img src="<?= "$root/$asset" ?>" alt="(image of <?= $name ?>)">