<?php
require_once 'init.php';

define('SRC', '.');
define('DEST', '../molero');
define('VIEWS', './views');
define('TEMPLATES', './templates');

// https://stackoverflow.com/a/3338133
function rrmdir($dir)
{
    if (is_dir($dir)) {
        $objects = scandir($dir);
        foreach ($objects as $object) {
            if ($object != "." && $object != "..") {
                if (is_dir($dir . DIRECTORY_SEPARATOR . $object) && !is_link($dir . "/" . $object))
                    rrmdir($dir . DIRECTORY_SEPARATOR . $object);
                else
                    unlink($dir . DIRECTORY_SEPARATOR . $object);
            }
        }
        rmdir($dir);
    }
}

// https://stackoverflow.com/a/7296238
function replace_extension($filename, $new_extension)
{
    $info = pathinfo($filename);
    return $info['filename'] . '.' . $new_extension;
}

function dir_entries($dir)
{
    $entries = scandir(SRC . '/' . $dir);
    unset($entries[array_search('.', $entries, true)]);
    unset($entries[array_search('..', $entries, true)]);

    if (count($entries) < 1) {
        return [];
    }

    return $entries;
}

function build_views($dir)
{
    foreach (dir_entries($dir) as $entry) {
        $path = $dir . '/' . $entry;
        if (is_dir(SRC . '/' . $path)) {
            mkdir(DEST . '/' . $path);
            build_views($path);
        } else if (str_ends_with($entry, '.php')) {
            build_php($path);
        } else {
            build_file($path);
        }
    }
}

function build_php($file)
{
    $path = $file;
    echo $path . "\n";
    $html = render_direct($path, array());
    echo $html;
    $dest = fopen(DEST . '/' . $path, 'w');
    fwrite($dest, $html);
}

function build_file($file)
{
    $path = '/' . $file;
    copy(SRC . $path, DEST . $path);
}

function build_dir($dir)
{
    foreach (dir_entries($dir) as $entry) {
        $path = $dir . '/' . $entry;
        if (is_dir(SRC . '/' . $path)) {
            if ($path === TEMPLATES) {
                continue;
            }
            mkdir(DEST . '/' . $path);
            if ($path === VIEWS) {
                build_views($path);
            } else {
                build_dir($path);
            }
        } else {
            build_file($dir . '/' . $entry);
        }
    }
}

function build()
{
    mkdir(DEST);
    build_dir('.');
}

$_SERVER['DOCUMENT_ROOT'] = __DIR__;
rrmdir(DEST);
build();
