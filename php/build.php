<?php require_once 'init.php';

$build = false;
$_SERVER['DOCUMENT_ROOT'] = __DIR__;

define('NAME', trim(getenv('OUTNAME'), '"'));
define('DEST', trim(getenv('TARGET'), '"') . '/' . NAME);
const INDEX = 'index.php';
const ASSETS = 'assets';
const MODELS = 'models';
const TEMPLATES = 'templates';
const VIEWS = 'views';

function view_path($file)
{
    $prefix = join_paths(__DIR__, VIEWS, '');
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

function template_kind($file)
{
    if (!str_ends_with($file, '.php')) {
        return 'raw';
    }
    $contents = file_get_contents($file);
    if (str_starts_with($contents, '<!DOCTYPE html>')) {
        return 'html';
    }
    if (str_starts_with($contents, '<?php ?>')) {
        return 'php';
    }
    return 'raw';
}

function path_to_root($path)
{
    $depth = substr_count($path, '/') - substr_count($path, './');
    return $depth <= 0 ? '.' : '..' . str_repeat('/..', $depth - 1);
}

function embed($file, $indent)
{
    $data = file_get_contents($file);
    $txt = '';
    $lines = preg_split("/((\r?\n)|(\r\n?))/", $data);
    if ($lines[array_key_last($lines)] === '//') {
        $lines[array_key_last($lines)] = '?>';
    }
    foreach ($lines as $line) {
        $txt = "$txt$indent$line\n";
    }
    $txt = trim($txt);
    return "$indent$txt";
}

function pront($line)
{
    return $line;
    // $line = addcslashes(trim($line, ' '), '\\\'');
    // if ($line === '') {
    //     return '';
    // }
    // return "print '$line';";
}

function php_escape($html)
{
    $php = '';
    foreach (preg_split("/((\r?\n)|(\r\n?))/", $html) as $line) {
        if (preg_match('/( *)(.*)(?:<embed src="(.*)">|embed="(.*)")(.*)/', $line, $m)) {
            [$_, $indent, $pre, $embed_tag, $embed_attr, $post] = $m;
            $embed = $embed_tag ?: $embed_attr;
            // an ad hoc, informally-specified, bug-ridden, slow implementation of half of Common Lisp
            global $templates;
            $embed = $templates[$embed]['path'];
            append($php, pront("$indent$pre"));
            append($php, embed($embed, $indent));
            append($php, pront("$post"));
        } else {
            append($php, pront($line));
        }
    }
    return trim($php);
}

function build_view($file)
{
    dbg($file, 'building view...');
    $dest = DEST . "/$file";
    $src = "views/$file";
    $kind = template_kind($src);
    if ($kind === 'raw') {
        copy($src, $dest);
        return;
    }

    // HACK: manual root path
    global $root;
    $root = path_to_root($file);
    $html = render_direct($src, [])['html'];
    if (!$html) {
        return;
    }
    $dest = replace_extension($dest, 'html');
    file_put_contents($dest, $html);
    `prettier --config .prettierrc --write $dest`;
    `sed -i 's/ \/>/>/' $dest`;
    `sed -i 's/doctype/DOCTYPE/' $dest`;

    // replace html with print statements
    if ($kind !== 'php') {
        return;
    }
    `sed -i 's/<?php ?>/<!DOCTYPE html>/' $dest`;

    $html = file_get_contents($dest);
    $escaped = php_escape($html);
    $php = "$escaped";
    `rm $dest`;
    $dest = replace_extension($dest, 'php');
    file_put_contents($dest, $php);
}

function build_model($path)
{
    csv_build(pathinfo($path)['filename']);
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
        } else if (str_ends_with($entry, '.csv')) {
            build_model($path, remove_extension($entry));
        }
    }
}

function register_template($name, $base, $path)
{
    global $templates;
    dbg([
        'name' => $name,
        'base' => $base,
        'path' => $path,
    ], 'registering');

    if (array_key_exists($name, $templates)) {
        error_log("Redefined $name");
        return;
    }
    $templates[$name] = [
        'base' => $base,
        'path' => $path,
        'lib' => false,
        'props' => [],
    ];
}

function update_template($name, $template)
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
    global $templates;

    $child_dirs = [];
    $child_files = [];
    $name = basename($dir);
    $template = $templates[$name] ?? false;
    dbg([
        'name' => $name,
        'template' => $template,
    ], 'building template');
    if ($template) {
        if (file_exists("$dir/_.php")) {
            $template['lib'] = "$dir/_.php";
        }
    }
    foreach (dir_entries($dir) as $entry) {
        $path = "$dir/$entry";
        if (is_dir($path)) {
            $child_dirs[] = $path;
        } else if ($entry === '.php') {
            // TODO: directory templates. why am i doing this.
            // $template['path'] = $path;
        } else if (str_ends_with($entry, '.php')) {
            $subname = basename($entry, '.php');
            if (str_starts_with($entry, '$')) {
                if ($template) {
                    $template['props'][extract_substr($subname, '$', '')] = $path;
                }
            } else if (!str_starts_with($entry, '_')) {
                $child_files[$subname] = $path;
            }
        }
    }
    if ($template) {
        $base = $name;
        $templates[$name] = $template;
    }
    foreach ($child_files as $name => $path) {
        register_template($name, $base, $path);
    }
    foreach ($child_dirs as $child) {
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

function append(&$data, $line)
{
    if ($line === '') return;
    $data .= "$line\n";
}

function build()
{
    global $build;
    $build = true;

    echo "Downloading assets...\n";
    mkdir(DEST);
    $cache = ASSETS;
    // rm_rf($cache);
    if (!file_exists($cache)) {
        mkdir($cache);
    }
    $assets = DEST . "/" . ASSETS;
    mkdir($assets);
    build_models(MODELS);
    `cp -r $cache/* $assets`;
    build_templates(null, TEMPLATES);
    build_views('.');
    $dest = DEST;
    foreach (dir_entries('.') as $path) {
        switch ($path) {
            case ASSETS:
            case MODELS:
            case TEMPLATES:
            case VIEWS:
                break;
            default:
                if (is_dir($path)) {
                    build_dir($path);
                }
        }
    }
    $dest = DEST;
    $name = NAME;
    `cd $dest && zip -r ../$name.zip *`;
    echo "Done.\n";
    $port = getenv('PORT');
    echo "Site up and running at: http://localhost:$port/$name/\n";

    $build = false;
}

build();
