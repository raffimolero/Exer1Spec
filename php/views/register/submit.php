<?php
$keys = array(
    'email',
    'password',
    'custname',
    'address',
    'number',
);

$data = array();
foreach ($keys as $key) {
    $data[] = $_POST[$key];
}

$fileHandle = fopen('../models/customers.csv', 'a');
$success = $fileHandle !== false;

$path = 'error.html';
if ($success) {
    fputcsv($fileHandle, $data);
    fclose($fileHandle);
    $path = '../login.php';
}

print '<meta http-equiv="refresh" content="0; url=' . $path . '">';
