<?php require_once 'control.php';
$asset = ASSETS . "/$name.jpeg";
// download_image($url, $asset);
?>

<img src="<?= $asset ?>" alt="(image of <?= $name ?>)">