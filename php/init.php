<?php
require_once 'models/csv.php';
require_once 'io.php';
require_once 'util.php';

$templates = [];

function render_direct($_path, $_data)
{
    unset($_data['_path']);
    ob_start();
    extract($_data);
    include $_path;
    unset($_data);
    return [
        'data' => get_defined_vars(),
        'html' => ob_get_clean(),
    ];
}

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
            extract($data);
            include_once $template['lib'];
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
