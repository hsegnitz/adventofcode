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

    public function testUnrotated(): void
    {
        $tile = new Tile(self::TILE);
        $this->assertEquals(2311, $tile->getId());
        $this->assertEquals(self::EDGE_TOP,    $tile->getTop());
        $this->assertEquals(self::EDGE_BOTTOM, $tile->getBottom());
        $this->assertEquals(self::EDGE_LEFT,   $tile->getLeft());
        $this->assertEquals(self::EDGE_RIGHT,  $tile->getRight());

        $this->assertEquals(self::EDGE_TOP,    $tile->getAppliedTop());
        $this->assertEquals(self::EDGE_LEFT,   $tile->getAppliedLeft());
        $this->assertEquals(self::EDGE_BOTTOM,   $tile->getAppliedBottom());
        $this->assertEquals(self::EDGE_RIGHT,  $tile->getAppliedRight());

        $tile->setFlipped(true);
        $this->assertEquals(self::EDGE_TOP_FLIPPED,    $tile->getAppliedTop());
        $this->assertEquals(self::EDGE_RIGHT,          $tile->getAppliedLeft());
        $this->assertEquals(self::EDGE_BOTTOM_FLIPPED, $tile->getAppliedBottom());
        $this->assertEquals(self::EDGE_LEFT,           $tile->getAppliedRight());
    }

    public function testAppliedAfterRotateLeft(): void
    {
        $tile = new Tile(self::TILE);
        $tile->setOrientation(Tile::ORIENTATION_LEFT);
        $this->assertEquals(self::EDGE_RIGHT,          $tile->getAppliedTop());
        $this->assertEquals(self::EDGE_TOP_FLIPPED,    $tile->getAppliedLeft());
        $this->assertEquals(self::EDGE_LEFT,           $tile->getAppliedBottom());
        $this->assertEquals(self::EDGE_BOTTOM_FLIPPED, $tile->getAppliedRight());

        $tile->setFlipped(true);
        $this->assertEquals(self::EDGE_LEFT,          $tile->getAppliedTop());
        $this->assertEquals(self::EDGE_TOP,           $tile->getAppliedLeft());
        $this->assertEquals(self::EDGE_RIGHT,         $tile->getAppliedBottom());
        $this->assertEquals(self::EDGE_BOTTOM,        $tile->getAppliedRight());
    }

    public function testAppliedAfterRotateRight(): void
    {
        $tile = new Tile(self::TILE);
        $tile->setOrientation(Tile::ORIENTATION_RIGHT);
        $this->assertEquals(self::EDGE_LEFT_FLIPPED,  $tile->getAppliedTop());
        $this->assertEquals(self::EDGE_BOTTOM,        $tile->getAppliedLeft());
        $this->assertEquals(self::EDGE_RIGHT_FLIPPED, $tile->getAppliedBottom());
        $this->assertEquals(self::EDGE_TOP,           $tile->getAppliedRight());

        $tile->setFlipped(true);
        $this->assertEquals(self::EDGE_RIGHT_FLIPPED,  $tile->getAppliedTop());
        $this->assertEquals(self::EDGE_BOTTOM_FLIPPED, $tile->getAppliedLeft());
        $this->assertEquals(self::EDGE_LEFT_FLIPPED,   $tile->getAppliedBottom());
        $this->assertEquals(self::EDGE_TOP_FLIPPED,    $tile->getAppliedRight());
    }

    public function testAppliedAfterRotateBottom(): void
    {
        $tile = new Tile(self::TILE);
        $tile->setOrientation(Tile::ORIENTATION_BOTTOM);
        $this->assertEquals(self::EDGE_BOTTOM_FLIPPED,  $tile->getAppliedTop());
        $this->assertEquals(self::EDGE_RIGHT_FLIPPED,   $tile->getAppliedLeft());
        $this->assertEquals(self::EDGE_TOP_FLIPPED,     $tile->getAppliedBottom());
        $this->assertEquals(self::EDGE_LEFT_FLIPPED,    $tile->getAppliedRight());

        $tile->setFlipped(true);
        $this->assertEquals(self::EDGE_BOTTOM,        $tile->getAppliedTop());
        $this->assertEquals(self::EDGE_LEFT_FLIPPED,  $tile->getAppliedLeft());
        $this->assertEquals(self::EDGE_TOP,           $tile->getAppliedBottom());
        $this->assertEquals(self::EDGE_RIGHT_FLIPPED, $tile->getAppliedRight());
    }

}
