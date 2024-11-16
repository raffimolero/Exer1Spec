<?php
function is_regex($req)
{
    return str_starts_with($req, '/') and str_ends_with($req, '/');
}

function requirement($id, $req)
{
    if (is_regex($req)) {
        return "!$req.test($id.value)";
    } else {
        return $req;
    }
}
