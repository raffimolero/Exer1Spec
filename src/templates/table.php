<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/init.php'; ?>

<?php $entries = csv_read($table) ?>
<table>
    <?php if ($entries) : ?>
        <?php foreach ($entries as $data) : ?>
            <tr>
                <?php foreach ($data as $cell) : ?>
                    <td><?= htmlspecialchars($cell) ?></td>
                <?php endforeach; ?>
            </tr>
        <?php endforeach; ?>
    <?php else: ?>
        <h1>[No data.]</h1>
    <?php endif; ?>
</table>