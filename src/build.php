<?php require_once 'init.php';

$_SERVER['DOCUMENT_ROOT'] = __DIR__;
define('DEST', '../' . trim(getenv('TARGET'), '"'));
const INDEX = 'index.php';
const ASSETS = 'assets';
const MODELS = 'models';
const TEMPLATES = 'templates';
const VIEWS = 'views';

function d($x)
{
    echo "DEBUG: '$x'\n";
    return $x;
}

// https://stackoverflow.com/a/4517270
function extract_substr($str, $prefix, $suffix)
{
    $start = '^' . preg_quote($prefix, '/');
    $end = preg_quote($suffix, '/') . '$';
    return preg_replace("/$start|$end/", '', $str);
}

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
    echo "Downloading assets...\n";
    mkdir(DEST);
    mkdir(DEST . "/" . ASSETS);
    foreach (dir_entries('.') as $path) {
        switch ($path) {
            case TEMPLATES:
                break;
            case MODELS:
                build_models($path);
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
}

build();
