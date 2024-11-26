<?php ?>
<?php ob_start(); ?>
<?= view('form', [
    'page' => view_path(__FILE__),
    'heading' => 'Login',
    'submit' => 'Log in',
    'name' => 'login',
    'validate' => false,
    'fields' => [
        ['Username', 'email', 'text', 'Your Email', 'rmolero@addu.edu.ph'],
        ['Password', 'password', 'password', 'Your Password', '123!@#OneTwoThree,,'],
    ],
]) ?>
<?php $body = ob_get_clean(); ?>

<?= view('template', [
    'title' => 'Login',
    'body' => $body,
]) ?>
