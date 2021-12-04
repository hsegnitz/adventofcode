<?php

namespace Y2017\D10;

use JetBrains\PhpStorm\Pure;

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

    public function hashBinary($input): string
    {
        $hashHex = $this->hash($input);

        $hashBin = '';
        foreach (str_split(strtolower($hashHex)) as $char) {
            switch ($char) {
                case "0": $hashBin .= '0000'; break;
                case "1": $hashBin .= '0001'; break;
                case "2": $hashBin .= '0010'; break;
                case "3": $hashBin .= '0011'; break;
                case "4": $hashBin .= '0100'; break;
                case "5": $hashBin .= '0101'; break;
                case "6": $hashBin .= '0110'; break;
                case "7": $hashBin .= '0111'; break;
                case "8": $hashBin .= '1000'; break;
                case "9": $hashBin .= '1001'; break;
                case "a": $hashBin .= '1010'; break;
                case "b": $hashBin .= '1011'; break;
                case "c": $hashBin .= '1100'; break;
                case "d": $hashBin .= '1101'; break;
                case "e": $hashBin .= '1110'; break;
                case "f": $hashBin .= '1111'; break;
            }
        }

        return $hashBin;
    }
}
