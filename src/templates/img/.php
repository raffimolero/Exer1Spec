<?php require_once 'control.php';
$asset = ASSETS . "/$name.jpeg";
// TODO:
// download_image($url, $asset);
?>

<img src="<?= $asset ?>" alt="(image of <?= $name ?>)">