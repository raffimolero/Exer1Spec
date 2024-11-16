<?php
if ($GLOBALS['build']) {
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

    return ['heading', 'name', 'page', 'fields', 'submit'];
}
?>

<script>
    <?php foreach ($fields as [$label, $id, $_type, $_placeholder, $requirements]) : ?>

        function validate() {
            err = '';

            <?php foreach ($requirements as $req => $err) : ?>
                <?php print "// $id"; ?>
                if (<?= requirement($id, $req) ?>) {
                    err += "<?= $label ?> must <?= $err ?>\n";
                }
            <?php endforeach; ?>

            success = err === '';
            if (success) {
                alert('Registered.');
            } else {
                alert('Failed to register:\n\n' + err);
            }
            return success;
        }
    <?php endforeach; ?>
</script>