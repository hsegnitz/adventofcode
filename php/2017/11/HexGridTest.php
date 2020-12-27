<?php

require __DIR__ . '/HexGrid.php';

use PHPUnit\Framework\TestCase;

class HexGridTest extends TestCase
{
    /**
     * @dataProvider pointsAndDistances
     * @param int $expectedDistance
     * @param int $q
     * @param int $r
     */
    public function testDistanceCalculation(int $expectedDistance, int $q, int $r): void
    {
        $hexGrid = new HexGrid();
        $this->assertEquals($expectedDistance, $hexGrid->getDistanceTo($q, $r));
    }

    /**
     * @dataProvider pathsAndDistances
     * @param string $path
     * @param int    $expectedDistance
     */
    public function testPathAndDistance(string $path, int $expectedDistance): void
    {
        $hexGrid = new HexGrid();
        $hexGrid->path($path);
        $this->assertEquals($expectedDistance, $hexGrid->getDistanceTo());
    }

    public function pointsAndDistances(): array
    {
        return [
            [0,  0,  0],
            [1,  0,  1],
            [1,  1,  0],
            [1,  1, -1],
            [1,  0, -1],
            [1, -1,  0],
            [1, -1, -1],
            [2,  2,  1],
        ];
    }

    public function pathsAndDistances(): array
    {
        return [
            ['ne,ne,ne', 3],
            ['ne,ne,sw,sw', 0],
            ['ne,ne,s,s', 2],
            ['se,sw,se,sw,sw', 3],
        ];
    }
}
