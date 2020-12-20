<?php

require __DIR__ . '/Tile.php';

use PHPUnit\Framework\TestCase;

class TileTestTest1 extends TestCase
{
    const TILE1 = <<<tile
Tile 2311:
..#abc..#.
##..#.....
#...##..#.
1###.#...#
2#.##.###7
3#...#.##8
.#.#.#..#9
..#....#..
###...#.#.
..#xyz.###
tile;

    const TILE2 = <<<tile
Tile 9871:
.#..cba#..
#.####...#
.....#..##
#...######
.##.#....#
.###.#####
###.##.##.
.###....#.
..#.#..#.#
#...##.#..
tile;

    const TILE3 = <<<tile
Tile 9871:
.#..xba#..
#.####...#
.....#..##
#...######
.##.#....#
.###.#####
###.##.##.
.###....#.
..#.#..#.#
#...##.#..
tile;


    public function testMatch(): void
    {
        $tile1 = new Tile(self::TILE1);
        $tile2 = new Tile(self::TILE2);

        $this->assertTrue($tile1->hasMatchingEdge($tile2));
    }

    public function testMiss(): void
    {
        $tile1 = new Tile(self::TILE1);
        $tile3 = new Tile(self::TILE3);

        $this->assertFalse($tile1->hasMatchingEdge($tile3));
    }


}
