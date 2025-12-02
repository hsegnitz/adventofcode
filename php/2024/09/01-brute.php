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

foreach ($disk as $pos => $blockContent) {
    if ($blockContent === '.') {
        $fromEnd = array_pop($disk);
        if ($fromEnd === '.') {
            $fromEnd = array_pop($disk);
        }
        if ($fromEnd === $blockContent) {
            $disk[] = $fromEnd;
            break;
        }
        $disk[$pos] = $fromEnd;
    }
}

#echo implode('', $disk), "\n";

$checksum = 0;
foreach (array_values($disk) as $pos => $value) {
    $checksum += $pos * (int)$value;
}

echo $checksum, "\n";



echo microtime(true) - $start;
echo "\n";
