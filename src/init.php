<?php
require_once 'models/csv.php';

function render_direct($path, $data)
{
    ob_start();
    extract($data);
    include $path;
    return ob_get_clean();
}

function render($view, $data)
{
    $path = "{$_SERVER['DOCUMENT_ROOT']}/templates/$view.php";
    return render_direct($path, $data);
}
