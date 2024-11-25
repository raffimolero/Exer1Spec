<?php ?>
<?php ob_start(); ?>
<?= view('products_dyn', []) ?>
<?php $body = ob_get_clean(); ?>

<!--
TODO:
- category sorting
- category deduplication
- login cookies
-->

<?= view('template', [
    'title' => 'Home',
    'body' => $body,
]) ?>