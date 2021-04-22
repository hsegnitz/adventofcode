<?php

require __DIR__ . '/HexGrid.php';

$startTime = microtime(true);

$hexGrid = new HexGrid();
$hexGrid->path(file_get_contents(__DIR__ . '/in.txt'));
echo $hexGrid->getDistanceTo(), "\n";
echo $hexGrid->getMaxDistance(), "\n";

echo "total time: ", (microtime(true) - $startTime), "\n";

