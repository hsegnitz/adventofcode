<?php

require __DIR__ . '/GarbageGourmet.php';

use PHPUnit\Framework\TestCase;

class GarbageGourmetTest extends TestCase
{

    /**
     * @dataProvider demoGroupScores
     * @param string $input
     * @param int $expected
     */
    public function testScore(string $input, int $expected): void
    {
        $garbageGourmet = new GarbageGourmet($input);
        $this->assertSame($expected, $garbageGourmet->score());
    }

    /**
     * @dataProvider demoGarbageScores
     * @param string $input
     * @param int $expected
     */
    public function testGarbageSize(string $input, int $expected): void
    {
        $garbageGourmet = new GarbageGourmet($input);
        $this->assertSame($expected, $garbageGourmet->getGarbageSize());
    }

    public function demoGroupScores(): array
    {
        return [
            0 => ['{}', 1],
            1 => ['{{{}}}', 6],
            2 => ['{{},{}}', 5],
            3 => ['{{{},{},{{}}}}', 16],
            4 => ['{<a>,<a>,<a>,<a>}', 1],
            5 => ['{{<ab>},{<ab>},{<ab>},{<ab>}}', 9],
            6 => ['{{<!!>},{<!!>},{<!!>},{<!!>}}', 9],
            7 => ['{{<a!>},{<a!>},{<a!>},{<ab>}}', 3],
        ];
    }

    public function demoGarbageScores(): array
    {
        return [
            0 => ['<>', 0],
            1 => ['<random characters>', 17],
            2 => ['<<<<>', 3],
            3 => ['<{!>}>', 2],
            4 => ['<!!>', 0],
            5 => ['<!!!>>', 0],
            6 => ['<{o"i!a,<{i<a>', 10],
        ];
    }
}
