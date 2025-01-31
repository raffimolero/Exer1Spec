<?php
$user_email = $_POST['email'];
$user_password = $_POST['password'];
$path = 'register.php';

$file = '../models/customers.csv';
if (file_exists($file) && ($fileHandle = fopen($file, 'r')) !== false) {
    while (($data = fgetcsv($fileHandle)) !== false) {
        $found_email = $data[0];
        $found_password = $data[1];
        $found_name = $data[2];
        if ($found_email === $user_email && $found_password === $user_password) {
            $path = 'index.php';
            setcookie('email', $found_email, 0, '/');
            setcookie('name', $found_name, 0, '/');
            break;
        }
    }
    fclose($fileHandle);
}

print '<meta http-equiv="refresh" content="0; url=../' . $path . '">';
