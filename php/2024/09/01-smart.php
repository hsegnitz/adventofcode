<?php

$start = microtime(true);

#$fileMap = str_split(file_get_contents('example.txt'));
#$fileMap = str_split(file_get_contents('example2.txt'));
$fileMap = str_split(file_get_contents('input.txt'));

$disk = [];
$fileId = -1;
foreach ($fileMap as $mapPos => $blockSize) {
    if ($mapPos % 2 === 0) {
        $fileId++;
        for ($i = 0; $i < $blockSize; $i++) {
            $disk[] = $fileId;
        }
    } else {
        for ($i = 0; $i < $blockSize; $i++) {
            $disk[] = '.';
        }
    }
}

#echo implode('', $disk), "\n";
#$backDisk = array_reverse($disk);
$backDisk = array_filter($disk, function($value) { return $value !== '.'; });

$totalBlocks = count($backDisk);

$newDisk = [];
foreach ($disk as $pos => $blockContent) {
    if (count($newDisk) >= $totalBlocks) {
        break;
    }

    if ($blockContent === '.') {
        $newDisk[] = array_pop($backDisk);
    } else {
        $newDisk[] = $blockContent;
    }
}

#echo implode('', $newDisk), "\n";

$checksum = 0;
foreach (array_values($newDisk) as $pos => $value) {
    $checksum += $pos * (int)$value;
}

echo $checksum, "\n";



echo microtime(true) - $start;
echo "\n";
