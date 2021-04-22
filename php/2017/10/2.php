<?php

use JetBrains\PhpStorm\Pure;

$startTime = microtime(true);

class KnotHash
{
    private array $list;
    private int $pos = 0;
    private int $skipsize = 0;

    #[Pure]
    public function __construct()
    {
        $this->list = range(0, 255);
    }

    private function knot(array $list, int $length): array
    {
        $size = count($list);

        $sublist = [];
        for ($i = 0; $i < $length; $i++) {
            $sublist[] = $list[($this->pos + $i) % $size];
        }
        $sublist = array_reverse($sublist);
        for ($i = 0; $i < $length; $i++) {
            $list[($this->pos + $i) % $size] = $sublist[$i];
        }
        $this->pos += $length + $this->skipsize++;

        return $list;
    }

    private function assemble(array $list): string
    {
        $hash = '';
        $chunks = array_chunk($list, 16);
        foreach ($chunks as $chunk) {
            $xor = array_shift($chunk);

            foreach($chunk as $elem) {
                $xor ^= $elem;
            }

            $hash .= sprintf('%02s', dechex($xor));
        }

        return $hash;
    }

    public function hash($input): string
    {
        $lengths = [];
        if ($input !== '') {
            $lengths = array_map('ord', str_split($input));
        }
        array_push($lengths, '17', '31', '73', '47', '23');

        $list = $this->list;
        for ($hashRun = 0; $hashRun < 64; $hashRun++) {
            foreach ($lengths as $length) {
                $list = $this->knot($list, $length);
            }
        }

        return $this->assemble($list);
    }
}

echo (new KnotHash())->hash(''), "\n";
echo (new KnotHash())->hash('AoC 2017'), "\n";
echo (new KnotHash())->hash('1,2,3'), "\n";
echo (new KnotHash())->hash('1,2,4'), "\n";
echo (new KnotHash())->hash("46,41,212,83,1,255,157,65,139,52,39,254,2,86,0,204"), "\n";


echo "total time: ", (microtime(true) - $startTime), "\n";

