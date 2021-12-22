<?php

require './Cube.php';
require './Reactor.php';

use PHPUnit\Framework\TestCase;

class ReactorTest extends TestCase
{
    public function testSingleCubeVolume(): void
    {
        $reactor = new Reactor();
        $reactor->add(new Cube(-1, 1, -1, 1, -1, 1));
        $this->assertEquals(27, $reactor->numberOfOns());
    }

    public function testAddingTwoNonOverlappingCubes(): void
    {
        $reactor = new Reactor();
        $reactor->add(new Cube(-1, 1, -1, 1, -1, 1));
        $reactor->add(new Cube(4, 5, 4, 5, 4, 5));
        $this->assertEquals(35, $reactor->numberOfOns());
    }

    public function testAddingContainedCube(): void
    {
        $reactor = new Reactor();
        $reactor->add(new Cube(-1, 1, -1, 1, -1, 1));
        $reactor->add(new Cube(4, 5, 4, 5, 4, 5));
        $reactor->add(new Cube(0, 0, 0, 0, 0, 0));  // this is just one "point"
        $this->assertEquals(35, $reactor->numberOfOns());
    }

    public function testAddingCubeWithIntersection(): void
    {
        $reactor = new Reactor();
        $reactor->add(new Cube(0, 10, 0, 10, 0, 10));
        $reactor->add(new Cube(4, 5, 4, 5, 4, 5));
        $this->assertEquals(35, $reactor->numberOfOns());
    }

    public function testRemovalOfFullyContainedCube(): void
    {
        $reactor = new Reactor();
        $reactor->add(new Cube(-1, 1, -1, 1, -1, 1));
        $reactor->add(new Cube(4, 5, 4, 5, 4, 5));
        $reactor->remove(new Cube(3, 5, 2, 6, 4, 6));
        $this->assertEquals(27, $reactor->numberOfOns());
    }

    public function testNonRemovalWhenSwitchingOffNonOverlaps(): void
    {
        $reactor = new Reactor();
        $reactor->add(new Cube(-1, 1, -1, 1, -1, 1));
        $reactor->remove(new Cube(4, 5, 4, 5, 4, 5));
        $this->assertEquals(27, $reactor->numberOfOns());
    }

}
