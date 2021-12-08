<?php

$startTime = microtime(true);

#$input = file('example0.txt');
#$input = file('example1.txt');
$input = file('./in.txt');

class SegmentedDisplay {

    private array $digitMap = [];

    public function deduceWirePattern (string $observed): void
    {
        $charCounts = count_chars($observed, 1);

        $segmentMap = [];
        $eightTimes = [];
        $sevenTimes = [];
        // the easies:
        foreach ($charCounts as $char => $count) {
            switch ($count) {
                case 4:
                    $segmentMap['e'] = chr($char);
                    break;
                case 6:
                    $segmentMap['b'] = chr($char);
                    break;
                case 9:
                    $segmentMap['f'] = chr($char);
                    break;
                case 7:
                    $sevenTimes[] = chr($char);
                    break;
                case 8:
                    $eightTimes[] = chr($char);
                    break;
            }
        }

        $patterns = explode(' ', $observed);

        $patternMap = [];

        foreach ($patterns as $pattern) {
            $patt = str_split(trim($pattern));
            sort($patt);
            $pat = implode('', $patt);

            switch (strlen($pat)) {
                case 2:
                    $this->digitMap[$pat] = 1;
                    $patternMap[1] = $patt;
                    break;
                case 3:
                    $this->digitMap[$pat] = 7;
                    $patternMap[7] = $patt;
                    break;
                case 4:
                    $this->digitMap[$pat] = 4;
                    $patternMap[4] = $patt;
                    break;
                case 7:
                    $this->digitMap[$pat] = 8;
                    $patternMap[8] = $patt;
                    break;
                case 5:
                case 6:
                    break;
                default:
                    throw new Exception('invalid pattern: ' . $pattern);
            }
        }


        $diff = array_diff($patternMap[7], $patternMap[1]);
        $segmentMap['a'] = array_pop($diff);

        $diff = array_diff($eightTimes, [$segmentMap['a']]);
        $segmentMap['c'] = array_pop($diff);

        $testForFour = [
            $segmentMap['b'],
            $segmentMap['c'],
            $segmentMap['f'],
            $sevenTimes[0],
        ];
        sort($testForFour);

        if ($patternMap[4] === $testForFour) {
            $segmentMap['d'] = $sevenTimes[0];
            $segmentMap['g'] = $sevenTimes[1];
        } else {
            $segmentMap['d'] = $sevenTimes[1];
            $segmentMap['g'] = $sevenTimes[0];
        }

        $patt = [$segmentMap['a'], $segmentMap['b'], $segmentMap['c'],                   $segmentMap['e'], $segmentMap['f'], $segmentMap['g']];
        sort ($patt);
        $this->digitMap[implode($patt)] = 0;

        $patt = [$segmentMap['a'],                   $segmentMap['c'], $segmentMap['d'], $segmentMap['e'],                   $segmentMap['g']];
        sort ($patt);
        $this->digitMap[implode($patt)] = 2;

        $patt = [$segmentMap['a'],                   $segmentMap['c'], $segmentMap['d'],                   $segmentMap['f'], $segmentMap['g']];
        sort ($patt);
        $this->digitMap[implode($patt)] = 3;

        $patt = [$segmentMap['a'], $segmentMap['b'],                   $segmentMap['d'],                   $segmentMap['f'], $segmentMap['g']];
        sort ($patt);
        $this->digitMap[implode($patt)] = 5;

        $patt = [$segmentMap['a'], $segmentMap['b'],                   $segmentMap['d'], $segmentMap['e'], $segmentMap['f'], $segmentMap['g']];
        sort ($patt);
        $this->digitMap[implode($patt)] = 6;

        $patt = [$segmentMap['a'], $segmentMap['b'], $segmentMap['c'], $segmentMap['d'],                   $segmentMap['f'], $segmentMap['g']];
        sort ($patt);
        $this->digitMap[implode($patt)] = 9;
    }

    public function parseNumber(string $out): int
    {
        $patterns = explode(' ', $out);

        $digits = '';

        foreach ($patterns as $pattern) {
            $patt = str_split(trim($pattern));
            sort($patt);
            $pat = implode('', $patt);

            $digits .= $this->digitMap[$pat];
        }

        return (int)$digits;
    }
}

$sum = 0;
foreach ($input as $line) {
    [$in, $out] = explode(' | ', $line);
    $segmentedDisplay = new SegmentedDisplay();
    $segmentedDisplay->deduceWirePattern($in);

    $sum += $segmentedDisplay->parseNumber($out);
}

echo $sum;

echo "\ntotal time: ", (microtime(true) - $startTime), "\n";


