<?php

function pipe(mixed $x, callable ...$fs)
{
    foreach ($fs as $f) $x = $f($x);
    return $x;
}

function ob(callable $f)
{
    ob_start();
    $f();
    return ob_get_clean();
}

function dbg(mixed $x, mixed ...$xs)
{
    error_log('DEBUG:');
    error_log(...$xs);
    error_log(ob(fn() => debug_print_backtrace()));

    error_log('VALUE:');
    error_log(print_r($x, true));
    error_log('');
    return $x;
}

// https://stackoverflow.com/a/4517270
function extract_substr(string $str, string $prefix, string $suffix)
{
    $start = '^' . preg_quote($prefix, '/');
    $end = preg_quote($suffix, '/') . '$';
    return preg_replace("/$start|$end/", '', $str);
}
