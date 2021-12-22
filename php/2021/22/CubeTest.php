<?php

require './Cube.php';

use PHPUnit\Framework\TestCase;

class CubeTest extends TestCase
{
    public function testVolume(): void
    {
        $cube = new Cube(-1, 2, -1, 2, -1, 2);
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

        $outsider = new Cube(100, 105, 100, 105, 100, 105);
        $this->assertFalse($outer->fullyContains($outsider));
        $this->assertFalse($outsider->fullyContains($outer));
    }

    public function testIntersectsWith(): void
    {
        $outer = new Cube(0, 5, 0, 5, 0, 5);
        $inner = new Cube(1, 5, 1, 5, 0, 4);
        $this->assertTrue($outer->intersectsWith($inner));
        $this->assertTrue($inner->intersectsWith($outer));

        $intersector = new Cube(3, 6, 1, 5, 0, 4);
        $this->assertTrue($outer->intersectsWith($intersector));
        $this->assertTrue($intersector->intersectsWith($outer));

        $outsider = new Cube(100, 105, 100, 105, 100, 105);
        $this->assertFalse($outer->intersectsWith($outsider));
        $this->assertFalse($outsider->intersectsWith($outer));
    }

    public function testAdjacent(): void
    {
        $a = new Cube(0, 10, 0, 10, 0, 10);
        $b = new Cube(10, 20, 0, 10, 0, 10);
        $this->assertFalse($a->intersectsWith($b));
        $this->assertFalse($b->intersectsWith($a));
    }

    public function testLayerOfOne(): void
    {
        $a = new Cube(0, 11, 0, 10, 0, 10);
        $b = new Cube(10, 20, 0, 10, 0, 10);
        $this->assertTrue($a->intersectsWith($b));
    }

    public function testFullyContainsWhenAtEdge(): void
    {
        $a = new Cube(0, 11, 0, 11, 0, 11);
        $b = new Cube(0, 5, 0, 5, 0, 5);
        $this->assertTrue($a->fullyContains($b));

        $a = new Cube(0, 11, 0, 11, 0, 11);
        $b = new Cube(5, 11, 1, 5, 1, 5);
        $this->assertTrue($a->fullyContains($b));
    }
}
