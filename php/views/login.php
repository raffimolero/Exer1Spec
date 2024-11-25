<!DOCTYPE html>

<?php ob_start(); ?>
<?= view('form', [
    'page' => view_path(__FILE__),
    'heading' => 'Login',
    'submit' => 'Log in',
    'name' => 'login',
    'validate' => false,
    'fields' => [
        ['Username', 'email', 'text', 'Your Email'],
        ['Password', 'password', 'password', 'Your Password'],
    ],
]) ?>
<?php $body = ob_get_clean(); ?>

<?= view('template', [
    'title' => 'Login',
    'body' => $body,
]) ?>