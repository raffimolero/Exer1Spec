<?php require($_SERVER['DOCUMENT_ROOT'] . '/init.php'); ?>
<?php
$keys = [
    'custname',
    'address',
    'number',
    'email',
    'password',
];

$data = [];
foreach ($keys as $key) {
    $data[] = $_POST[$key];
}

if (csv_push('customers', $data)) {
    redirect('register/success');
} else {
    redirect('register/error');
}
