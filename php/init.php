<?php
require_once 'models/csv.php';
require_once 'io.php';
require_once 'util.php';

$templates = [];

function render_direct($_path, $_data, $_once = false, $_merge = true)
{
    // validate input
    foreach ($_data as $key => $val) {
        if (str_starts_with($key, '_')) {
            dbg($_data, "ERROR: tried to render with special path from $_path");
            return;
        }
    }

    // perform include
    extract($_data);
    ob_start();
    if ($_once) {
        include_once $_path;
    } else {
        include $_path;
    }

    // append newly defined globals to data
    if ($_merge) {
        $_data = get_defined_vars();
    }

    // sanitize input
    foreach ($_data as $key => $val) {
        if (str_starts_with($key, '_')) {
            unset($_data[$key]);
        }
    }

    return [
        'html' => ob_get_clean(),
        'data' => $_data,
    ];
}

// recursively render the specified view with $data as context
function view($view, $data)
{
    global $templates;

    while ($view !== null) {
        if (!array_key_exists($view, $templates)) {
            error_log("tried to load $view");
            return "<h1>ERROR</h1>";
        };

        $template = $templates[$view];

        $path = $template['path'];
        if ($template['lib']) {
            $data = array_merge(
                $data,
                render_direct($template['lib'], $data, true)['data'],
            );
        }

        $props = array_map(
            function ($prop) use ($data) {
                return render_direct($prop, $data)['html'];
            },
            $template['props'],
        );
        $data = array_merge($data, $props);
        ['html' => $html, 'data' => $d2] = render_direct($path, $data);
        $data = array_merge($data, $d2);
        print $html;
        $view = $template['base'];
    }
}
