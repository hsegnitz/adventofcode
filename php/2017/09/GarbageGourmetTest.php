<?php

require __DIR__ . '/GarbageGourmet.php';

use PHPUnit\Framework\TestCase;

class GarbageGourmetTest extends TestCase
{

    /**
     * @dataProvider demo
     * @param string $input
     * @param int $expected
     */
    public function testTop(string $input, int $expected): void
    {
        $garbageGourmet = new GarbageGourmet($input);
        $this->assertSame($expected, $garbageGourmet->score($input));
    }

    public function demo(): array
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


}

