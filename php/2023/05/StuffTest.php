<?php

namespace Year2023\Day05;

include '02-classes.php';

class StuffTest extends \PHPUnit\Framework\TestCase
{
    /** @var array|Map[]  */
    private static array $maps = [];

    public static function setUpBeforeClass(): void
    {
        $input = file_get_contents('example.txt');

        $blocks = explode("\n\n", $input);
        $seeds = explode(" ", array_shift($blocks));
        array_shift($seeds);

        foreach ($blocks as $block) {
            self::$maps[] = new Map($block);
        }
    }

    public function testSeedRangeOutOfMapRangeReturnsUnchanged(): void
    {
        $firstMap = self::$maps[0];
        $seedRanges = [new SeedRange(30, 40)];
        $this->assertEquals($seedRanges, $firstMap->convert($seedRanges));
    }

    public function testSeedRangeInsideMapRangeReturnsTransformed(): void
    {
        $firstMap = self::$maps[0];
        $seedRange = [new SeedRange(55, 67)];
        $this->assertEquals([new SeedRange(57, 69)], $firstMap->convert($seedRange));
    }

    public function testSeedRangeOverlapReturnsSmallerAndTransformed(): void
    {
        $firstMap = self::$maps[0];
        $seedRange = [new SeedRange(44, 57)];
        $this->assertEquals([new SeedRange(44, 49), new SeedRange(52, 59)], $firstMap->convert($seedRange));
    }

    public function testSeedRangeDoubleOverlapReturnsThree(): void
    {
        $this->markTestSkipped('insufficient test data');
        $firstMap = self::$maps[0];
        $seedRange = [new SeedRange(44, 57)];
        $this->assertEquals([new SeedRange(44, 49), new SeedRange(52, 59)], $firstMap->convert($seedRange));
    }

    public function testSeedMatchesTwoRanges(): void
    {
        $firstMap = self::$maps[0];
        $seedRange = [new SeedRange(96, 98)];
        $this->assertEquals([new SeedRange(98, 99), new SeedRange(50, 50)], $firstMap->convert($seedRange));
    }

    public function testTwoSeedsMatches(): void
    {
        $firstMap = self::$maps[0];
        $seedRange = [new SeedRange(55, 67), new SeedRange(79, 92), ];
        $this->assertEquals([new SeedRange(57, 69), new SeedRange(81, 94)], $firstMap->convert($seedRange));
    }
}