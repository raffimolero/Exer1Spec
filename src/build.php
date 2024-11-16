<?php require_once 'init.php';

$_SERVER['DOCUMENT_ROOT'] = __DIR__;
const DEST = '../molero';
const INDEX = 'index.php';
const MODELS = 'models';
const TEMPLATES = 'templates';
const VIEWS = 'views';

function d($x)
{
    echo "DEBUG: $x\n";
    return $x;
}

function dir_entries($dir)
{
    return array_diff(scandir($dir), ['.', '..']);
}

// https://stackoverflow.com/a/3338133
function rm_rf($dir)
{
    foreach (dir_entries($dir) as $file) {
        $path = "$dir/$file";
        if (is_dir($path) && !is_link($path)) {
            rm_rf($path);
        } else {
            unlink($path);
        }
    }
    return rmdir($dir);
}

// https://stackoverflow.com/questions/193794/how-can-i-change-a-files-extension-using-php#comment31326878_7296238
function replace_extension($path, $ext)
{
    $info = pathinfo($path);
    $dir = $info['dirname'];
    $name = $info['filename'];
    return "$dir/$name.$ext";
}

function build_file($file)
{
    clearstatcache();
    if (!filesize($file)) {
        return;
    }
    copy($file, DEST . "/$file");
}

function build_php($file)
{
    $line = fgets(fopen($file, 'r'));
    if (!str_starts_with($line, '<?php require')) {
        build_file($file);
        return;
    }

    $html = render_direct($file, array());
    if (!$html) {
        return;
    }
    $file = replace_extension($file, 'html');
    $dest = fopen(DEST . "/$file", 'w');
    fwrite($dest, $html);
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
    mkdir(DEST . "/$dir");
    foreach (dir_entries($dir) as $entry) {
        $path = "$dir/$entry";
        if (is_dir($path)) {
            build_views($path);
        } else if (str_ends_with($entry, '.php')) {
            build_php($path);
        } else {
            build_file($path);
        }
    }
}

function build()
{
    mkdir(DEST);
    foreach (dir_entries('.') as $path) {
        switch ($path) {
            case TEMPLATES:
                break;
            case MODELS:
                build_models($path);
                break;
            case VIEWS:
                build_views($path);
                break;
            default:
                if (is_dir($path)) {
                    build_dir($path);
                }
        }
    }
    $dest = DEST;
    $views = VIEWS;
    `mv $dest/$views/* $dest`;
    rmdir("$dest/$views");
}

if (file_exists(DEST)) {
    rm_rf(DEST);
}
build();
