<?php

require './Cube.php';
require './Reactor.php';

use PHPUnit\Framework\TestCase;

class ReactorTest extends TestCase
{
    public function testSingleCubeVolume(): void
    {
        $reactor = new Reactor();
        $reactor->add(new Cube(-1, 2, -1, 2, -1, 2));
        $this->assertEquals(27, $reactor->numberOfOns());
    }

    public function testAddingTwoNonOverlappingCubes(): void
    {
        $reactor = new Reactor();
        $reactor->add(new Cube(-1, 2, -1, 2, -1, 2));
        $reactor->add(new Cube(4, 6, 4, 6, 4, 6));
        $this->assertEquals(35, $reactor->numberOfOns());
    }

    public function testAddingContainedCube(): void
    {
        $reactor = new Reactor();
        $reactor->add(new Cube(-1, 2, -1, 2, -1, 2));
        $reactor->add(new Cube(4, 6, 4, 6, 4, 6));
        $reactor->add(new Cube(0, 1, 0, 1, 0, 1));  // this is just one "point"
        $this->assertEquals(35, $reactor->numberOfOns());
    }

    public function testAddingCubeWithIntersection(): void
    {
        $reactor = new Reactor();
        $reactor->add(new Cube(0, 2, 0, 2, 0, 2));    //  2x2x2  --  8
        $reactor->add(new Cube(1, 3, 1, 3, 1, 3));    //  2x2x2  --  8
        $this->assertEquals(15, $reactor->numberOfOns());  //  1x1x1 intersection, right?  so 15
    }

    public function testAddingCubeWithTwoIntersections(): void
    {
        $reactor = new Reactor();
        $reactor->add(new Cube(0, 2, 0, 2, 0, 2));    //  2x2x2  --   8
        $reactor->add(new Cube(4, 6, 4, 6, 4, 6));    //  2x2x2  --   8
        $reactor->add(new Cube(1, 5, 1, 5, 1, 5));    //  4x4x4  --  64
        $this->assertEquals(78, $reactor->numberOfOns());  //  two 1x1x1 intersection, right?  so 64+8+8-2 = 78
    }

    public function testRemovalOfFullyContainedCube(): void
    {
        $reactor = new Reactor();
        $reactor->add(new Cube(-1, 2, -1, 2, -1, 2));
        $reactor->add(new Cube(4, 6, 4, 6, 4, 6));
        $reactor->remove(new Cube(3, 6, 2, 7, 4, 7));
        $this->assertEquals(27, $reactor->numberOfOns());
    }

    public function testNonRemovalWhenSwitchingOffNonOverlaps(): void
    {
        $reactor = new Reactor();
        $reactor->add(new Cube(-1, 2, -1, 2, -1, 2));
        $reactor->remove(new Cube(4, 6, 4, 6, 4, 6));
        $this->assertEquals(27, $reactor->numberOfOns());
    }

    public function testRemoveCubeWithIntersectionFromCorner(): void
    {
        $reactor = new Reactor();
        $reactor->add(new Cube(0, 3, 0, 3, 0, 3));   // 3x3x3 -> 27
        $reactor->remove(new Cube(1, 4, 1, 4, 1, 4));   //  3x3x3 -> 27   but with 2x2x2  overlap between the two
        $this->assertEquals(19, $reactor->numberOfOns());
    }

    public function testRemoveCubeWithinCube(): void
    {
        $reactor = new Reactor();
        $reactor->add(new Cube(0, 3, 0, 3, 0, 3));   // 3x3x3 -> 27
        $reactor->remove(new Cube(1, 2, 1, 2, 1, 2));   //  1x1x1 -> 1   full overlap
        $this->assertEquals(26, $reactor->numberOfOns());

        $reactor = new Reactor();
        $reactor->add(new Cube(0, 10, 0, 10, 0, 10));   // 10x10x10 -> 1000
        $reactor->remove(new Cube(2, 5, 2, 5, 2, 5));   //  3x3x3 -> 27   full overlap
        $this->assertEquals(973, $reactor->numberOfOns());
    }
}
