<?php

require __DIR__ . '/Tile.php';

use PHPUnit\Framework\TestCase;

class TileRotateTest extends TestCase
{
    const TILE = <<<tile
Tile 2311:
.###.
#123#
#456#
#789#
.###.
tile;

    public function testTop(): void
    {
        $tile = new Tile(self::TILE);
        $expected = [
            [1,2,3],
            [4,5,6],
            [7,8,9],
        ];
        $this->assertEquals($expected, $tile->getCroppedAndAlignedContent());

        $tile->setFlipped(true);
        $expected = [
            [3,2,1],
            [6,5,4],
            [9,8,7],
        ];
        $this->assertEquals($expected, $tile->getCroppedAndAlignedContent());
    }

    public function testBottom(): void
    {
        $tile = new Tile(self::TILE);
        $tile->setOrientation(Tile::ORIENTATION_BOTTOM);
        $expected = [
            [9,8,7],
            [6,5,4],
            [3,2,1],
        ];
        $this->assertEquals($expected, $tile->getCroppedAndAlignedContent());

        $tile->setFlipped(true);
        $expected = [
            [7,8,9],
            [4,5,6],
            [1,2,3],
        ];
        $this->assertEquals($expected, $tile->getCroppedAndAlignedContent());
    }

    public function testLeft(): void
    {
        $tile = new Tile(self::TILE);
        $tile->setOrientation(Tile::ORIENTATION_LEFT);
        $expected = [
            [3,6,9],
            [2,5,8],
            [1,4,7],
        ];
        $this->assertEquals($expected, $tile->getCroppedAndAlignedContent());

        $tile->setFlipped(true);
        $expected = [
            [1,4,7],
            [2,5,8],
            [3,6,9],
        ];
        $this->assertEquals($expected, $tile->getCroppedAndAlignedContent());
    }

    public function testRight(): void
    {
        $tile = new Tile(self::TILE);
        $tile->setOrientation(Tile::ORIENTATION_RIGHT);
        $expected = [
            [7,4,1],
            [8,5,2],
            [9,6,3],
        ];
        $this->assertEquals($expected, $tile->getCroppedAndAlignedContent(), 'regular');

        $tile->setFlipped(true);
        $expected = [
            [9,6,3],
            [8,5,2],
            [7,4,1],
        ];
        $this->assertEquals($expected, $tile->getCroppedAndAlignedContent(), 'flipped');
    }


}

