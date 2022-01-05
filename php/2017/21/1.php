<?php

$startTime = microtime(true);

#$input = file('./demo.txt', FILE_IGNORE_NEW_LINES);
$input = file('./in.txt', FILE_IGNORE_NEW_LINES);

$lines = [
    '.#.',
    '..#',
    '###',
];


class PatternMatcher {
    private array $patterns = [];

    public function __construct(array $input)
    {
        foreach ($input as $line) {
            [$pattern, $result] = explode(' => ', $line);
            foreach ($this->permutatePatterns($pattern) as $pp) {
                if (isset($this->patterns[$pp])) {
                    throw new RuntimeException('came up with a pattern that was already in definitions');
                }
                $this->patterns[$pp] = explode('/', $result);
            }
        }
    }

    private function permutatePatterns(string $p): array
    {
        $permutations = [$p];

        if (strlen($p) === 5) { // 01/34
            // rotating original
            $permutations[] = $p[1] . $p[4] . '/' . $p[0] . $p[3];
            $permutations[] = $p[4] . $p[3] . '/' . $p[1] . $p[0];
            $permutations[] = $p[3] . $p[0] . '/' . $p[4] . $p[1];

            // flip and rotate
            $permutations[] = $p[1] . $p[0] . '/' . $p[4] . $p[3];
            $permutations[] = $p[0] . $p[3] . '/' . $p[1] . $p[4];
            $permutations[] = $p[3] . $p[4] . '/' . $p[0] . $p[1];
            $permutations[] = $p[4] . $p[1] . '/' . $p[3] . $p[0];
        } else {
            // rotating original
            $permutations[] = $p[2] . $p[6] . $p[10] . '/' . $p[1] . $p[5] . $p[9] . '/' . $p[0] . $p[4] . $p[8];
            $permutations[] = $p[10] . $p[9] . $p[8] . '/' . $p[6] . $p[5] . $p[4] . '/' . $p[2] . $p[1] . $p[0];
            $permutations[] = $p[8] . $p[4] . $p[0] . '/' . $p[9] . $p[5] . $p[1] . '/' . $p[10] . $p[6] . $p[2];

            // flip and rotate
            $permutations[] = $p[2] . $p[1] . $p[0] . '/' . $p[6] . $p[5] . $p[4] . '/' . $p[10] . $p[9] . $p[8];
            $permutations[] = $p[0] . $p[4] . $p[8] . '/' . $p[1] . $p[5] . $p[9] . '/' . $p[2] . $p[6] . $p[10];
            $permutations[] = $p[10] . $p[6] . $p[2] . '/' . $p[9] . $p[5] . $p[1] . '/' . $p[8] . $p[4] . $p[0];
            $permutations[] = $p[8] . $p[9] . $p[10] . '/' . $p[4] . $p[5] . $p[6] . '/' . $p[0] . $p[1] . $p[2];
        }

        return array_unique($permutations);
    }

    public function match(string $in): array
    {
        return $this->patterns[$in];
    }
}

$matcher = new PatternMatcher($input);

#for ($i = 0; $i < 5; $i++) {  //  part 1
for ($i = 0; $i < 18; $i++) {
    $newLines = [];
    if (count($lines) % 2 === 0) {
        for ($row = 0, $rowMax = count($lines); $row < $rowMax; $row += 2) {
            $newRow = ($row / 2 * 3);
            $newLines[$newRow]   = '';
            $newLines[$newRow+1] = '';
            $newLines[$newRow+2] = '';

            for ($col = 0; $col < $rowMax; $col += 2) {
                $match = substr($lines[$row], $col, 2) . '/' . substr($lines[$row+1], $col, 2);
                $result = $matcher->match($match);
                $newLines[$newRow]     .= $result[0];
                $newLines[$newRow + 1] .= $result[1];
                $newLines[$newRow + 2] .= $result[2];
            }
        }
    } else {
        for ($row = 0, $rowMax = count($lines); $row < $rowMax; $row += 3) {
            $newRow = ($row / 3 * 4);
            $newLines[$newRow]   = '';
            $newLines[$newRow+1] = '';
            $newLines[$newRow+2] = '';
            $newLines[$newRow+3] = '';

            for ($col = 0; $col < $rowMax; $col += 3) {
                $match = substr($lines[$row], $col, 3) . '/' . substr($lines[$row+1], $col, 3) . '/' . substr($lines[$row+2], $col, 3);
                $result = $matcher->match($match);
                $newLines[$newRow]   .= $result[0];
                $newLines[$newRow+1] .= $result[1];
                $newLines[$newRow+2] .= $result[2];
                $newLines[$newRow+3] .= $result[3];
            }
        }
    }

    $lines = $newLines;
}

echo count_chars(implode ('', $lines), 1)[35];

echo "\ntotal time: ", number_format(microtime(true) - $startTime, 6), "\n";
