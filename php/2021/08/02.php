<?php

$startTime = microtime(true);

$input = file('example0.txt');
#$input = file('example1.txt');
#$input = file('./in.txt');

class SegmentedDisplay {

    private const CANDIDATE_LIST = ['a' => true, 'b' => true, 'c' => true, 'd' => true, 'e' => true, 'f' => true, 'g' => true];

    private array $candidates = [
        0 => self::CANDIDATE_LIST,
        1 => self::CANDIDATE_LIST,
        2 => self::CANDIDATE_LIST,
        3 => self::CANDIDATE_LIST,
        4 => self::CANDIDATE_LIST,
        5 => self::CANDIDATE_LIST,
        6 => self::CANDIDATE_LIST,
    ];

    private array $digitMap = [];

    // we start assuming that all segments could be lit by all wires.
    // each count of digits has a certain "antipattern" - segments that can't be lit.
    // so we remove those from the respective sets
    public function deduceWirePattern (string $observed): void
    {
        foreach (explode(' ', $observed) as $pattern) {
            $patt = str_split(trim($pattern));
            switch (strlen(trim($pattern))) {
                case 2:
                    $this->removeCandidates($patt, [0, 1, 3, 4, 6]);
                    break;
                case 3:
                    $this->removeCandidates($patt, [1, 3, 4, 6]);
                    break;
                case 4:
                    $this->removeCandidates($patt, [0, 4, 6]);
                    break;
                case 5:
                case 6:
                case 7:
                    # those are useless :(
                    break;
                default:
                    throw new Exception('invalid pattern: ' . $pattern);
            }
        }
    }

    private function removeCandidates(array $patt, array $positions): void
    {
        foreach ($positions as $pos) {
            foreach (array_keys(self::CANDIDATE_LIST) as $letter) {
                if (in_array($letter, $patt)) {
                    continue;
                }
                unset ($this->candidates[$pos][$letter]);
            }
        }
    }
}



foreach ($input as $line) {
    [$in, $out] = explode(' | ', $line);
    $segmentedDisplay = new SegmentedDisplay();
    $segmentedDisplay->deduceWirePattern($in);
    print_r($segmentedDisplay);
}



echo "\ntotal time: ", (microtime(true) - $startTime), "\n";


