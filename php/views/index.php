<!DOCTYPE html>
<?php ob_start(); ?>
<?= view('products', []) ?>
<?php $body = ob_get_clean(); ?>

<?= view('template', [
    'title' => 'Home',
    'body' => $body,
]) ?>