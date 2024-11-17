<?php
$data = csv_read('products');
$columns = ['category', 'item', 'stock', 'image'];
?>
<table>
    <tr>
        <?php foreach ($columns as $column) : ?>
            <th>
                <h2><?= $column ?></h2>
            </th>
        <?php endforeach; ?>
    </tr>
    <?php if ($data) : ?>
        <?php foreach ($data as $entry) : ?>
            <?php extract(array_combine($columns, $entry)) ?>
            <tr>
                <td>
                    <h3><?= htmlspecialchars($category) ?></h3>
                </td>
                <td>
                    <h3><?= htmlspecialchars($item) ?></h3>
                </td>
                <td>
                    <h3><?= htmlspecialchars($stock) ?></h3>
                </td>
                <td>
                    <?= render('img', [
                        'name' => $item,
                        'url' => $image,
                    ]) ?>
                </td>
            </tr>
        <?php endforeach; ?>
    <?php else: ?>
        <h1>[No data.]</h1>
    <?php endif; ?>
</table>