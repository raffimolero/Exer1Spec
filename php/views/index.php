<?php ?>
<?php ob_start(); ?>
<?= view('products_dyn', []) ?>
<?php $body = ob_get_clean(); ?>

<!--
TODO:
- category sorting
- category deduplication
-->

<?= view('template', [
    'title' => 'Home',
    'body' => $body,
]) ?>