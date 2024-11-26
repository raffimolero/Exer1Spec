<?php
$file = './models/products.csv';
if (!file_exists($file)) {
    print '<h1>No Data.</h1>';
    return;
}
// TODO: print the categories

// print the main table
print '<br>';
print '<table>';
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
