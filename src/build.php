<?php require_once 'init.php';

$build = false;
$_SERVER['DOCUMENT_ROOT'] = __DIR__;

define('DEST', '../' . trim(getenv('TARGET'), '"'));
const INDEX = 'index.php';
const ASSETS = 'assets';
const MODELS = 'models';
const TEMPLATES = 'templates';
const VIEWS = 'views';

function view_path($file)
{
    $prefix = __DIR__ . DIRECTORY_SEPARATOR . VIEWS . DIRECTORY_SEPARATOR;
    $suffix = '.php';
    return extract_substr($file, $prefix, $suffix);
}

function build_file($file)
{
    clearstatcache();
    if (!filesize($file)) {
        return;
    }
    copy($file, DEST . "/$file");
}

function is_template($file)
{
    return str_ends_with($file, '.php') and str_starts_with(fgets(fopen($file, 'r')), '<!DOCTYPE html>');
}

function build_view($file)
{
    $dest = DEST . "/$file";
    $src = "views/$file";
    if (!is_template($src)) {
        copy($src, $dest);
        return;
    }

    $html = render_direct($src, array());
    if (!$html) {
        return;
    }
    $dest = replace_extension($dest, 'html');
    file_put_contents($dest, $html);
}

function build_dir($dir)
{
    mkdir(DEST . "/$dir");
    foreach (dir_entries($dir) as $entry) {
        $path = "$dir/$entry";
        if (is_dir($path)) {
            build_dir($path);
        } else {
            build_file($path);
        }
    }
}

function build_models($dir)
{
    mkdir(DEST . "/$dir");
    foreach (dir_entries($dir) as $entry) {
        $path = "$dir/$entry";
        if (is_dir($path)) {
            build_views($path);
        } else if (!str_ends_with($entry, '.php')) {
            build_file($path);
        }
    }
}

function register_template($name, $template)
{
    global $templates;

    if (array_key_exists($name, $templates)) {
        error_log("Redefined $name");
        return;
    }
    $templates[$name] = $template;
}

function build_templates($base, $dir)
{
    $children = [];
    $template = ['base' => $base, 'path' => false, 'props' => []];
    foreach (dir_entries($dir) as $entry) {
        $path = "$dir/$entry";
        if (is_dir($path)) {
            $children[] = $path;
        } else if ($entry === '.php') {
            $template['path'] = $path;
        } else if (str_ends_with($entry, '.php')) {
            $name = basename($entry, '.php');
            if (str_starts_with($entry, '$')) {
                $template['props'][extract_substr($name, '$', '')] = $path;
            } else if (!str_starts_with($entry, '_')) {
                register_template($name, ['path' => $path, 'props' => []]);
            }
        }
    }
    if ($template['path']) {
        $base = basename($dir);
        register_template($base, $template);
    }
    foreach ($children as $child) {
        build_templates($base, $child);
    }
}

function build_views($dir)
{
    foreach (dir_entries(VIEWS . "/$dir") as $entry) {
        $path = "$dir/$entry";
        if (is_dir(VIEWS . "/$path")) {
            mkdir(DEST . "/$path");
            build_views($path);
        } else {
            build_view($path);
        }
    }
}

function build()
{
    global $build;
    $build = true;

    echo "Downloading assets...\n";
    mkdir(DEST);
    mkdir(DEST . "/" . ASSETS);
    foreach (dir_entries('.') as $path) {
        switch ($path) {
            case MODELS:
                build_models($path);
                break;
            case TEMPLATES:
                build_templates(null, $path);
                break;
            case VIEWS:
                build_views('.');
                break;
            default:
                if (is_dir($path)) {
                    build_dir($path);
                }
        }
    }
    echo "Done.\n";

    $build = false;
}

build();
