<?php

function dir_entries(string $dir): array
{
    return array_diff(scandir($dir) ?: [], ['.', '..']);
}

function join_paths(...$paths): string
{
    $out = join('/', $paths);
    $out = preg_replace('/[\\/]+/', DIRECTORY_SEPARATOR, $out);
    return $out;
}

function path_heckery($path, ...$heckery)
{
    $info = pathinfo($path);
    $map = [
        PATHINFO_DIRNAME => 'dirname',
        PATHINFO_FILENAME => 'filename',
        PATHINFO_BASENAME => 'basename',
        PATHINFO_EXTENSION => 'extension',
    ];
    $heckify = fn($heck) => $info[$map[$heck] ?? null] ?? $heck;
    $hecked = array_map($heckify, $heckery);
    return join_paths(DIRECTORY_SEPARATOR, ...$hecked);
}

// https://stackoverflow.com/questions/193794/how-can-i-change-a-files-extension-using-php#comment31326878_7296238
function remove_extension($path)
{
    return path_heckery($path, PATHINFO_DIRNAME, PATHINFO_FILENAME);
}

function replace_extension($path, $ext)
{
    dbg(pathinfo($path)['filename'], 'file name');
    return path_heckery($path, PATHINFO_DIRNAME, PATHINFO_FILENAME) . ".$ext";
}

// https://stackoverflow.com/a/724449
function download($url, $file)
{
    file_put_contents($file, file_get_contents($url));

    // $ch = curl_init($url);
    // $fp = fopen($file, 'wb');
    // curl_setopt($ch, CURLOPT_FILE, $fp);
    // curl_setopt($ch, CURLOPT_HEADER, 0);
    // curl_exec($ch);
    // curl_close($ch);
    // fclose($fp);
}
