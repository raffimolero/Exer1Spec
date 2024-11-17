<?php

if (extension_loaded('tidy')) {
    echo 'Tidy extension is loaded!';
} else {
    echo 'Tidy extension is not loaded.';
}

// chatgpt
function format_html($html)
{
    return $html; //HACK
    // Create a new Tidy object
    $tidy = new tidy();

    // Clean and format the HTML
    $clean_html = $tidy->repairString($html, [
        'indent' => true,   // Enable indentation
        'wrap' => 200       // Line wrap length
    ]);

    // Output the formatted HTML
    return $clean_html;
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
function remove_extension($path)
{
    $info = pathinfo($path);
    $dir = $info['dirname'];
    $name = $info['filename'];
    return "$dir/$name";
}

function replace_extension($path, $ext)
{
    return remove_extension($path) . ".$ext";
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
