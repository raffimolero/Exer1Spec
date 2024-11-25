<?php
$file = './models/products.csv';
if (file_exists($file)) {
    print '<table>';
    $fileHandle = fopen($file, 'r');
    while (($data = fgetcsv($fileHandle)) !== false) {
        $category = $data[0];
        $name = $data[1];
        $stock = $data[2];
        $link = $data[3];
        print '<tr>';
        print '<td>' . $category . '</td>';
        print '<td><a href="' . $link . '">' . $name . '</a></td>';
        print '<td>' . $stock . '</td>';
        print '<td><a href="' . $link . '"><img src="./assets/' . $name . '.jpeg" alt="(image of ' . $name . ')"></a></td>';
        print '</tr>';
    }
    print '</table>';
} else {
    print '<h1>No Data.</h1>';
}
