<?php
$action = 'in';
if (isset($_COOKIE['name'])) {
    $action = 'out';
}
print '<a href="log' . $action . '.php">Log ' . $action . '</a>';
