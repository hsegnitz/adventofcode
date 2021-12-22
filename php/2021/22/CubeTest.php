<?php

require './Cube.php';

use PHPUnit\Framework\TestCase;

class CubeTest extends TestCase
{
    public function testVolume(): void
    {
        $cube = new Cube(-1, 1, -1, 1, -1, 1);
        $this->assertEquals(27, $cube->volume());
    }

    public function testFullyContains(): void
    {
        $outer = new Cube(0, 5, 0, 5, 0, 5);
        $inner = new Cube(1, 5, 1, 5, 0, 4);
        $this->assertTrue($outer->fullyContains($inner));
        $this->assertFalse($inner->fullyContains($outer));

        $intersector = new Cube(3, 6, 1, 5, 0, 4);
        $this->assertFalse($outer->fullyContains($intersector));
        $this->assertFalse($intersector->fullyContains($outer));
    }
}
