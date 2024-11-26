<?php

$file = './models/products.csv';
if (!file_exists($file)) {
    print '<h1>No Data.</h1>';
    return;
}

// find unique categories
$categories = array();
print '<br>';
print '<div class="categories">';
$fileHandle = fopen($file, 'r');
while (($data = fgetcsv($fileHandle)) !== false) {
    $category = $data[0];
    $exists = false;
    foreach ($categories as $existing_category) {
        if ($category === $existing_category) {
            $exists = true;
            break;
        }
    }
    if ($exists) {
        continue;
    }
    $categories[] = $category;
    print '<a href="index.php?category=' . $category . '"><div class="categories hover';
    if (isset($_GET['category']) && $_GET['category'] === $category) {
        print ' selected';
    }
    print '">' . $category . '</div></a>';
}
print '</div>';

// render products
print '<br>';
print '<table>';
print '<tr>';
print '<th>Category</th>';
print '<th>Name</th>';
print '<th>Stock</th>';
print '<th>Image</th>';
print '</tr>';
$fileHandle = fopen($file, 'r');
while (($data = fgetcsv($fileHandle)) !== false) {
    $category = $data[0];
    $name = $data[1];
    $stock = $data[2];
    $link = $data[3];

    // filter by category
    if (isset($_GET['category']) && $_GET['category'] !== $category) {
        continue;
    }

    print '<tr>';
    print '<td><a href="index.php?category=' . $category . '">' . $category . '</a></td>';
    print '<td><a href="' . $link . '">' . $name . '</a></td>';
    print '<td>' . $stock . '</td>';
    print '<td><a href="' . $link . '"><img src="./assets/' . $name . '.jpeg" alt="(image of ' . $name . ')"></a></td>';
    print '</tr>';
}
print '</table>';

print '<br>';
