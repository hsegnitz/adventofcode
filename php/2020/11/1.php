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
    private int   $changeCounter = 0;
    private array $neighbours = [];
    private int   $tolerance;

    public function __construct(array $seatMap, bool $secondDay = false)
    {
        $this->seatMap = $seatMap;
        if ($secondDay) {
            $this->tolerance = 5;
            $this->mapNeighboursDay2();
            return;
        }
        $this->tolerance = 4;
        $this->mapNeighboursDay1();
    }

    public function mapNeighboursDay1(): void
    {
        for ($row = 0, $rowMax = count($this->seatMap); $row < $rowMax; $row++) {
            for ($col = 0, $colMax = count($this->seatMap[$row]); $col < $colMax; $col++) {
                $this->neighbours[$row][$col] = [];
                if (isset($this->seatMap[$row-1][$col-1] ) && $this->seatMap[$row-1][$col-1] !== '.') { $this->neighbours[$row][$col][] = &$this->seatMap[$row-1][$col-1]; }
                if (isset($this->seatMap[$row-1][$col] )   && $this->seatMap[$row-1][$col]   !== '.') { $this->neighbours[$row][$col][] = &$this->seatMap[$row-1][$col]; }
                if (isset($this->seatMap[$row-1][$col+1] ) && $this->seatMap[$row-1][$col+1] !== '.') { $this->neighbours[$row][$col][] = &$this->seatMap[$row-1][$col+1]; }
                if (isset($this->seatMap[$row][$col-1] )   && $this->seatMap[$row][$col-1]   !== '.') { $this->neighbours[$row][$col][] = &$this->seatMap[$row][$col-1]; }
                if (isset($this->seatMap[$row][$col+1] )   && $this->seatMap[$row][$col+1]   !== '.') { $this->neighbours[$row][$col][] = &$this->seatMap[$row][$col+1]; }
                if (isset($this->seatMap[$row+1][$col-1] ) && $this->seatMap[$row+1][$col-1] !== '.') { $this->neighbours[$row][$col][] = &$this->seatMap[$row+1][$col-1]; }
                if (isset($this->seatMap[$row+1][$col] )   && $this->seatMap[$row+1][$col]   !== '.') { $this->neighbours[$row][$col][] = &$this->seatMap[$row+1][$col]; }
                if (isset($this->seatMap[$row+1][$col+1] ) && $this->seatMap[$row+1][$col+1] !== '.') { $this->neighbours[$row][$col][] = &$this->seatMap[$row+1][$col+1]; }
            }
        }
    }

    public function mapNeighboursDay2(): void
    {
        for ($row = 0, $rowMax = count($this->seatMap); $row < $rowMax; $row++) {
            for ($col = 0, $colMax = count($this->seatMap[$row]); $col < $colMax; $col++) {
                $this->neighbours[$row][$col] = [];
                $this->neighbours[$row][$col][] = &$this->traceFirstSeat($row, $col, -1, -1);
                $this->neighbours[$row][$col][] = &$this->traceFirstSeat($row, $col, -1,  0);
                $this->neighbours[$row][$col][] = &$this->traceFirstSeat($row, $col, -1,  1);
                $this->neighbours[$row][$col][] = &$this->traceFirstSeat($row, $col,  0, -1);
                $this->neighbours[$row][$col][] = &$this->traceFirstSeat($row, $col,  0, +1);
                $this->neighbours[$row][$col][] = &$this->traceFirstSeat($row, $col,  1, -1);
                $this->neighbours[$row][$col][] = &$this->traceFirstSeat($row, $col,  1,  0);
                $this->neighbours[$row][$col][] = &$this->traceFirstSeat($row, $col,  1,  1);
            }
        }
    }

    private function &traceFirstSeat(int $row, int $col, int $rowInc, int $colInc): string
    {
        $i = 1;
        $newRow = $row + ($i * $rowInc);
        $newCol = $col + ($i * $colInc);

        while (isset($this->seatMap[$newRow][$newCol]) && '.' === $this->seatMap[$newRow][$newCol]) {
            $i++;
            $newRow = $row + ($i * $rowInc);
            $newCol = $col + ($i * $colInc);
        }

        if (isset($this->seatMap[$newRow][$newCol])) {
            return $this->seatMap[$newRow][$newCol];
        }
        $blank = '';
        return $blank;
    }

    public function newStateOfSeat($row, $col): string
    {
        $current = $this->seatMap[$row][$col];
        if ($current === '.') {
            return '.'; // Floor, floor never changes.
        }

        $counts = array_count_values($this->neighbours[$row][$col]);
        if ($current === 'L' && !isset($counts['#'])) {
            ++ $this->changeCounter;
            return '#';
        }
        if ($current === '#' && isset($counts['#']) && $counts['#'] >= $this->tolerance) {
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

    private function applyNewSeatMap(array $newSeatMap): void
    {
        foreach ($newSeatMap as $row => $rowItems) {
            foreach ($rowItems as $col => $type) {
                $this->seatMap[$row][$col] = $type;
            }
        }
    }

    public function run(): void
    {
        while (true) {
            $newSeatMap = $this->round();
            $this->applyNewSeatMap($newSeatMap);
            if ($this->changeCounter === 0) {
                echo $this->serializeSeatMap($newSeatMap);
                return;
            }
        }
    }
}

$ferry = new Ferry($seatMap, true);

echo $ferry->serializeSeatMap($seatMap);
#die();

$ferry->run();


echo $ferry->countOccupiedSeats(), "\n";

echo "total time: ", (microtime(true) - $startTime), "\n";
