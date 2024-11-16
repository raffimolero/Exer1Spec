<?php
require_once 'models/csv.php';
require_once 'io.php';

$templates = ['hello' => 'world'];

function render_direct($path, $data)
{
    ob_start();
    extract($data);
    include $path;
    return ob_get_clean();
}

function render($view, $data)
{
    global $templates;

    if (!array_key_exists($view, $templates)) {
        error_log("tried to load $view");
        return "<h1>ERROR</h1>";
    };
    $path = $templates[$view]['path'];
    $props = array_map(
        function ($prop) use ($data) {
            return render_direct($prop, $data);
        },
        $templates[$view]['props'],
    );
    return render_direct("$path", array_merge($props, $data));
}
