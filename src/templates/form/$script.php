<?php require_once '_.php'; ?>
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