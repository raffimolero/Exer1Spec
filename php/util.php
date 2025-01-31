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

const AB = ['A', 'B'];
const EXPECT = ['Actual', 'Expect'];
const OLDNEW = ['Old', 'New'];

function dbg_eq(mixed $a, mixed $b, ?array $keys = AB)
{
    dbg(
        [
            $keys[0] => $a,
            $keys[1] => $b,
        ],
        $a === $b ? 'Values were equal as expected' : 'Warning: Values were expected to equal, but were not.',
    );
    return $a;
}

function dbg(mixed $x, ?string $msg)
{
    error_log("[ DEBUG ]");
    // error_log(ob(fn() => debug_print_backtrace()));
    error_log("MESSAGE: $msg");
    error_log('VALUE:');
    error_log(print_r($x, true));
    error_log('[ /DEBUG ]');
    return $x;
}

// https://stackoverflow.com/a/4517270
function extract_substr(string $str, string $prefix, string $suffix)
{
    $start = '^' . preg_quote($prefix, '/');
    $end = preg_quote($suffix, '/') . '$';
    return preg_replace("/$start|$end/", '', $str);
}
