<?php
$email = $_POST['email'];
$password = $_POST['password'];

$fileHandle = fopen('../models/customers.csv', 'r');

$path = 'register';
if ($fileHandle !== false) {
    while (($data = fgetcsv($fileHandle)) !== false) {
        if ($data[0] === $email && $data[1] === $password) {
            $path = 'index';
        }
    }
    fclose($fileHandle);
}

print '<meta http-equiv="refresh" content="0; url=../' . $path . '.html">';
