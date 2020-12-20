<?php

require __DIR__ . '/Tile.php';

use PHPUnit\Framework\TestCase;

class TileTestTest extends TestCase
{
    const TILE = <<<tile
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

    const EDGE_TOP    = '..#abc..#.';
    const EDGE_LEFT   = '.##123..#.';
    const EDGE_RIGHT  = '...#789..#';
    const EDGE_BOTTOM = '..#xyz.###';

    const EDGE_TOP_FLIPPED    = '.#..cba#..';
    const EDGE_LEFT_FLIPPED   = '.#..321##.';
    const EDGE_RIGHT_FLIPPED  = '#..987#...';
    const EDGE_BOTTOM_FLIPPED = '###.zyx#..';

    public function testUnmodifiedEdges(): void
    {
        $tile = new Tile(self::TILE);
        $this->assertEquals(2311, $tile->getId());
        $this->assertEquals(self::EDGE_TOP,    $tile->getTop());
        $this->assertEquals(self::EDGE_BOTTOM, $tile->getBottom());
        $this->assertEquals(self::EDGE_LEFT,   $tile->getLeft());
        $this->assertEquals(self::EDGE_RIGHT,  $tile->getRight());
    }

    public function testEdgesFlippedHorz(): void
    {
        $tile = new Tile(self::TILE);

        $tile->setFlippedHorz(true);
        $this->assertEquals(self::EDGE_TOP_FLIPPED, $tile->getTop());
        $this->assertEquals(self::EDGE_RIGHT,   $tile->getLeft());
        $this->assertEquals(self::EDGE_LEFT,  $tile->getRight());
        $this->assertEquals(self::EDGE_BOTTOM_FLIPPED, $tile->getBottom());
    }

    public function testEdgesFlippedVert(): void
    {
        $tile = new Tile(self::TILE);

        $tile->setFlippedVert(true);
        $this->assertEquals(self::EDGE_BOTTOM,        $tile->getTop());
        $this->assertEquals(self::EDGE_LEFT_FLIPPED,  $tile->getLeft());
        $this->assertEquals(self::EDGE_RIGHT_FLIPPED, $tile->getRight());
        $this->assertEquals(self::EDGE_TOP,           $tile->getBottom());
    }



}
