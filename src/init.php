<?php
require_once 'models/csv.php';
require_once 'io.php';

function render_direct($path, $data)
{
    ob_start();
    extract($data);
    include $path;
    return ob_get_clean();
}

function render($view, $data)
{
    $path = "{$_SERVER['DOCUMENT_ROOT']}/templates/$view";
    $infix = file_exists("$path.php") ? '' : '/view';
    return render_direct("$path$infix.php", $data);
}
