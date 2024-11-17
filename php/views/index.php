<!DOCTYPE html>
<?php ob_start(); ?>
<?= render('products', []) ?>
<?php $body = ob_get_clean(); ?>

<?= render('template', [
    'title' => 'Home',
    'body' => $body,
]) ?>