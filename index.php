<?php
require __DIR__ . '/vendor/autoload.php';

use Intervention\Image\ImageManagerStatic as Image;

$imageDir = 'C:/Users/Trung Do/Desktop/ok/';
$outDir = __DIR__ . '/out/';
$limit = 5;

if (!file_exists($imageDir)) {
    die('not found');
}

// Returns an array of files
$files = scandir($imageDir);

unset($files[0]);
unset($files[1]);
$files = array_values($files);

$numFiles = count($files);


$firstFile = $files[0];
$h = 1600;
$w = 690;

$imageTmp = Image::make(__DIR__ . '/init.png');
$imageTmp = $imageTmp->resize($w, $h * $numFiles);

natsort($files);
$chunks = array_chunk($files, $limit);


$chunkIndex = 0;
foreach ($chunks as $chunk) {

    for ($i = 0; $i < count($chunk); $i++) {
        $file = $chunk[$i];
        $nextImg = $imageDir . '/' . $file;

        $posX = 0;
        $posY = ($chunkIndex * $h * $limit) + ($h * $i);



        $imageTmp->insert($nextImg, 'top-left', $posX, $posY);

        echo $file . '- y:' . $posY . '<br />';
    }

    echo 'Chunk: ' . $chunkIndex . '<br />';

    $chunkIndex++;
}

$imageTmp
    ->save($outDir . '/' . time() . '.png', 90);

die('done');
