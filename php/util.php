<?php

function append(&$data, $line)
{
    if ($line === '') {
        return;
    }
    $data = "$data$line\n";
}

function dbg($x, $msg = 'no message')
{
    error_log("DEBUG: $msg");
    // error_log("BACKTRACE:");
    // prettyPrintArray(debug_backtrace());
    prettyPrintArray($x);
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
function prettyPrintArray($array, $indent = 1)
{
    if (is_array($array)) {
        if ($indent > 3) {
            error_log(str_repeat("    ", $indent) . "...[" . count($array) . " element(s) omitted]");
            return;
        }
        foreach ($array as $key => $value) {
            $start = str_repeat("    ", $indent) . $key . " => ";
            if (is_array($value)) {
                error_log($start . "[");
                prettyPrintArray($value, $indent + 1);
                error_log(str_repeat("    ", $indent) . "]");
            } else {
                error_log("$start$value");
            }
        }
    } else {
        error_log(str_repeat("    ", $indent) . $array);
    }
}
