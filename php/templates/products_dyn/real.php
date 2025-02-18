<?php

// load products data
$file = './models/products.csv';
$fileHandle = fopen($file, 'r');
if (!$fileHandle) {
    print '<h1>No Data.</h1>';
    return;
}

$products = array();
while (($row = fgetcsv($fileHandle)) !== false) {
    $products[] = $row;
}
fclose($fileHandle);

// find unique categories
$categories = array();
$i = 0;
while ($i < count($products)) {
    $j = 0;
    $isUnique = true;
    while ($j < count($categories)) {
        if ($products[$i][0] == $categories[$j]) {
            $isUnique = false;
            break;
        }
        $j++;
    }
    if ($isUnique) {
        $categories[] = $products[$i][0];
    }
    $i++;
}

?>
<br>
<div class="categories">
    <?php
    for ($i = 0; $i < count($categories); $i++) {
        $category = $categories[$i];

        $isSelected = isset($_GET['category']) && $_GET['category'] === $category;
        if (!$isSelected) print '<a href="index.php?category=' . $category . '">';
        print '<div class="hover';
        if ($isSelected) print ' selected';
        print '">' . $category . '</div>';
        if (!$isSelected) print '</a>';
    }
    ?>
</div>
<br>
<table>
    <tr>
        <th>
            <h1>Product ID</h1>
        </th>
        <th>
            <h1>Category</h1>
        </th>
        <th>
            <h1>Name</h1>
        </th>
        <th>
            <h1>Stock</h1>
        </th>
        <th>
            <h1>Image</h1>
        </th>
    </tr>
    <?php
    for ($id = 0; $id < count($products); $id++) {
        $category = $products[$id][0];
        $name = $products[$id][1];
        $stock = $products[$id][2];
        $link = $products[$id][3];

        // filter by category
        if (isset($_GET['category']) && $_GET['category'] !== $category) {
            continue;
        }

        print '<tr>';
        print '<td><h1>' . $id . '</h1></td>';
        print '<td><h2><a href="index.php?category=' . $category . '">' . $category . '</a></h2></td>';
        print '<td><h2><a href="' . $link . '">' . $name . '</a></h2></td>';
        print '<td><h1>' . $stock . '</h1></td>';
        print '<td><a href="./assets/' . $name . '.jpeg' . '"><img src="./assets/' . $name . '.jpeg" alt="(image of ' . $name . ')"></a></td>';
        print '</tr>';
    }
    ?>
</table>
<br>