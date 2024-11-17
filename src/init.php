<?php
require_once 'models/csv.php';
require_once 'io.php';
require_once 'util.php';

$templates = [];

function include_with($path, $data)
{
    extract($data);
    include $path;
}

function render_direct($path, $data)
{
    ob_start();
    include_with($path, $data);
    return ob_get_clean();
}

function render($view, $data)
{
    global $templates;

    dbg(['view' => $view, 'data' => $data], 'start');

    if ($view === null) {
        return;
    }

    $template = $templates[$view];
    if (!array_key_exists($view, $templates)) {
        error_log("tried to load $view");
        return "<h1>ERROR</h1>";
    };
    $path = $template['path'];
    $props = array_map(
        function ($prop) use ($data) {
            return render_direct($prop, $data);
        },
        $template['props'],
    );
    dbg([
        'data' => $data,
        'view' => $view,
        'template' => $template,
    ], 'trying to render');
    $data = array_merge($data, $props);
    if ($template['lib']) {
        extract($data);
        include_once $template['lib'];
    }
    include_with($path, $data);
    render($template['base'], $data);
}
