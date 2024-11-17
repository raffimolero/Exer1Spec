<script>
    function validate() {
        err = '';
        <?php foreach ($fields as [$label, $id, $_type, $_placeholder, $requirements]) : ?>
            <?php print "// $id\n"; ?>
            <?php foreach ($requirements as $err => $req) : ?>
                if (<?= requirement($id, $req) ?>) {
                    err += "<?= $label ?> must <?= $err ?>\n";
                }
            <?php endforeach; ?>

        <?php endforeach; ?>
        success = err === '';
        if (success) {
            alert('Registered.');
        } else {
            alert('Failed to register:\n' + err);
        }
        return success;
    }
</script>