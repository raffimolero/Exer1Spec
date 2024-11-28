<?php
$keys = array(
    'email',
    'password',
    'custname',
    'address',
    'number',
);

setcookie('email', $_POST['email'], 0, '/');

$data = array();
foreach ($keys as $key) {
    $data[] = $_POST[$key];
}

$fileHandle = fopen('../models/customers.csv', 'a');
$success = $fileHandle !== false;

$path = '../register.php';
if ($success) {
    fputcsv($fileHandle, $data);
    fclose($fileHandle);
    $path = '../login.php';
}

print '<meta http-equiv="refresh" content="0; url=' . $path . '">';
