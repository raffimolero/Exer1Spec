<!DOCTYPE html>

<?php ob_start(); ?>
<?= view('form', [
    'page' => view_path(__FILE__),
    'heading' => 'Register',
    'submit' => 'Register',
    'name' => 'register',
    /*
    Molero, Raffi, O.
    123, Petal Str., Agdao, Davao City
    0912-345-6789
    rmolero@addu.edu.ph
    123!@#OneTwoThree,,
    123!@#OneTwoThree,,
    */
    'validate' => true,
    'fields' => [
        ['Name', 'custname', 'text', 'Lastname, Firstname M.', [
            'follow the format Lastname, Firstname, M.' => '/^[A-Z][a-z]*, (?:[A-Z][a-z]* )*[A-Z][a-z]*, [A-Z]\.$/'
        ]],
        ['Address', 'address', 'text', '123, Petal Str., Agdao, Davao City', [
            'follow the format Blk. Street. Barangay, City' => '/^\w+, [\w \.]+, [\w \.]+, [\w \.]+$/'
        ]],
        ['Number', 'number', 'text', '09xx-xxx-xxxx', [
            'be a valid number like 0912-345-6789' => '/^09\d{2}-\d{3}-\d{4}$/'
        ]],
        ['Email', 'email', 'text', 'username@example.com',  [
            'be a valid email like name@example.com' => '/^[\w\.]+@\w+(?:\.\w+)+$/'
        ]],
        ['Password', 'password', 'password', 'strong password', [
            'contain at least one special character' => '/\W/',
            'contain at least one digit' => '/\d/',
            'contain at least one lowercase letter' => '/[a-z]/',
            'contain at least one CAPITAL LETTER' => '/[A-Z]/',
            'contain at least 8 characters' => '/.{8}/',
        ]],
        ['Confirm Password', 'confirmpassword', 'password', 're-type password', ['match Password' => 'confirmpassword.value !== password.value']],
    ],
]) ?>
<?php $body = ob_get_clean(); ?>

<?= view('template', [
    'title' => 'Register',
    'body' => $body,
]) ?>