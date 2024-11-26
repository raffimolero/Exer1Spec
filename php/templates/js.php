<?php
$script = preg_replace("/    (.*)((\r?\n)|(\r\n?))/", '${1}${2}', $script);
$script = preg_replace('/<\/?script>/', '', $script);
$dest = DEST . "/$path";
file_put_contents($dest, $script);
`prettier --config .prettierrc --write $dest`;
?>
<script src="<?= $path ?>"></script>