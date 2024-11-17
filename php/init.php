<?php
require_once 'models/csv.php';
require_once 'io.php';
require_once 'util.php';

$templates = [];

function render_direct($path, $data)
{
    ob_start();
    extract($data);
    include $path;
    return ob_get_clean();
}

function view($view, $data)
{
    global $templates;

    extract($data);
    while ($view !== null) {
        if (!array_key_exists($view, $templates)) {
            error_log("tried to load $view");
            return "<h1>ERROR</h1>";
        };

        $template = $templates[$view];

        $path = $template['path'];
        if ($template['lib']) {
            include_once $template['lib'];
        }

        $props = array_map(
            function ($prop) use ($data) {
                return render_direct($prop, $data);
            },
            $template['props'],
        );
        extract($props);
        include $path;
        dbg($heading, 'test');
        $view = $template['base'];
    }
}
