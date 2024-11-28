<?php

function dbg($x, ...$xs)
{
    var_dump([
        'DEBUG' => [...$xs],
        'TRACE' => debug_backtrace(),
        'VALUE' => $x,
    ]);
    error_log('');
    return $x;
}

// https://stackoverflow.com/a/4517270
function extract_substr($str, $prefix, $suffix)
{
    $start = '^' . preg_quote($prefix, '/');
    $end = preg_quote($suffix, '/') . '$';
    return preg_replace("/$start|$end/", '', $str);
}

// chatgpt
// Function to pretty print an associative array recursively
function prettyPrintArray($array, $indent = 1) {}
