<?php
$name = '';
if (isset($_COOKIE['name'])) {
    $name = $_COOKIE['name'];
}
if ($name !== '') {
    print '<h3>Welcome, ' . $name . '!</h3>';
}
