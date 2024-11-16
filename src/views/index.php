<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/init.php'; ?>

<?= render('template', [
    'title' => 'Home',
    'body' => render('products', []),
]) ?>