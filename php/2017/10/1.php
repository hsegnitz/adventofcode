<?php

$startTime = microtime(true);

$data = range(0, 4);
$lengths = explode(',', "3,4,1,5");
/* */
$data = range(0, 255);
$lengths = explode(',', "46,41,212,83,1,255,157,65,139,52,39,254,2,86,0,204");
/* */

class KnotHash
{
    private int $pos = 0;
    private int $skipsize = 0;

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

    public function __invoke(array $list, array $lengths): array
    {
        foreach ($lengths as $length) {
            $list = $this->knot($list, $length);
        }
        return $list;
    }
}

$data = (new KnotHash())($data, $lengths);

echo $data[0] * $data[1], "\n";

echo "total time: ", (microtime(true) - $startTime), "\n";

