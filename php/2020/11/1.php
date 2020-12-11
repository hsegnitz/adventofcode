<?php

$startTime = microtime(true);

$input = file(__DIR__ .'/in.txt');
$seatMap = [];
foreach ($input as $row) {
    $seatMap[] = str_split('.' . trim($row) . '.');
}
$seatMap[] = array_fill(0, count($seatMap[0]), '.');
array_unshift($seatMap, array_fill(0, count($seatMap[0]), '.'));



class Ferry {
    private array $seatMap;
    private int $changeCounter = 0;

    public function __construct(array $seatMap)
    {
        $this->seatMap = $seatMap;
    }

    public function newStateOfSeat($row, $col): string
    {
        $current = $this->seatMap[$row][$col];
        if ($current === '.') {
            return '.'; // Floor, floor never changes.
        }

        $neighbours = [];
        $neighbours[] = $this->seatMap[$row-1][$col-1];
        $neighbours[] = $this->seatMap[$row-1][$col];
        $neighbours[] = $this->seatMap[$row-1][$col+1];
        $neighbours[] = $this->seatMap[$row][$col-1];
        $neighbours[] = $this->seatMap[$row][$col+1];
        $neighbours[] = $this->seatMap[$row+1][$col-1];
        $neighbours[] = $this->seatMap[$row+1][$col];
        $neighbours[] = $this->seatMap[$row+1][$col+1];

        $counts = array_count_values($neighbours);
        if ($current === 'L' && !isset($counts['#'])) {
            ++ $this->changeCounter;
            return '#';
        }
        if ($current === '#' && isset($counts['#']) && $counts['#'] >= 4) {
            ++ $this->changeCounter;
            return 'L';
        }
        return $current;
    }

    public function round(): array
    {
        $this->changeCounter = 0;
        $newSeatMap = [];
        for ($row = 0, $rowMax = count($this->seatMap); $row < $rowMax; $row++) {
            for ($col = 0, $colMax = count($this->seatMap[$row]); $col < $colMax; $col++) {
                $newSeatMap[$row][$col] = $this->newStateOfSeat($row, $col);
            }
        }
        return $newSeatMap;
    }

    public function countOccupiedSeats(): int
    {
        $counts = count_chars($this->serializeSeatMap($this->seatMap));
        return $counts[ord('#')];
    }

    public function serializeSeatMap(array $map): string
    {
        $out = '';
        foreach ($map as $row) {
            $out .= implode('', $row) . "\n";
        }
        return $out;
    }

    public function run(): void
    {
        while (true) {
            $newSeatMap = $this->round();
            $this->seatMap = $newSeatMap;
            if ($this->changeCounter === 0) {
                echo $this->serializeSeatMap($newSeatMap);
                return;
            }
        }
    }
}

$ferry = new Ferry($seatMap);

echo $ferry->serializeSeatMap($seatMap);
#die();

$ferry->run();


echo $ferry->countOccupiedSeats(), "\n";

echo "total time: ", (microtime(true) - $startTime), "\n";
