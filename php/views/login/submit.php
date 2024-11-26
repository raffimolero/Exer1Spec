<?php
$email = $_POST['email'];
$password = $_POST['password'];

$fileHandle = fopen('../models/customers.csv', 'r');

$path = 'register.php';
if ($fileHandle !== false) {
    while (($data = fgetcsv($fileHandle)) !== false) {
        if ($data[0] === $email && $data[1] === $password) {
            $path = 'index.php';
            setcookie('email', $data[0]);
            setcookie('name', $data[2]);
        }
    }
    fclose($fileHandle);
}

print '<meta http-equiv="refresh" content="0; url=../' . $path . '">';
