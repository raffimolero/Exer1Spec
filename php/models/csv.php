<?php

$id = -1;

$model_maps = [
    'products' => function ($category, $name, $stock, $image, $link) {
        global $id;
        download_image($image, $name);
        $id++;
        return [$id, $category, $name, $stock, $link];
    },
];

function csv_build($table)
{
    global $model_maps;
    $f = $model_maps[$table] ?? fn($x) => $x;
    $data = csv_read($table);

    // https://stackoverflow.com/a/31118307
    // Write to memory (unless buffer exceeds 2mb when it will write to /tmp)
    $fp = fopen('php://temp', 'w+');
    foreach ($data as $fields) {
        // Add row to CSV buffer
        fputcsv($fp, $f(...$fields));
    }
    rewind($fp); // Set the pointer back to the start
    $csv_contents = trim(stream_get_contents($fp)); // Fetch the contents of our CSV
    fclose($fp); // Close our pointer and free up memory and /tmp space

    if ($csv_contents !== '') {
        file_put_contents(DEST . "/models/$table.csv", $csv_contents);
    }
}

function csv_path($table)
{
    return __DIR__ . '/' . $table . '.csv';
}

function csv_read($table)
{
    $file = csv_path($table);
    $entries = [];

    $fileHandle = fopen($file, 'r');
    if ($fileHandle !== false) {
        while (($data = fgetcsv($fileHandle)) !== false) {
            $entries[] = $data;
        }
        fclose($fileHandle);
    }
    return $entries;
}

function csv_push($table, $data)
{
    $fileHandle = fopen(csv_path($table), 'a');
    $success = $fileHandle !== false;
    if ($success) {
        fputcsv($fileHandle, $data);
        fclose($fileHandle);
    }
    return $success;
}
