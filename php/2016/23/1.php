<?php

$program = [];
$register = [
    'a' => 12,
    'b' => 0,
    'c' => 0,
    'd' => 0,
];

foreach (file(__DIR__ . '/in.txt') as $row) {
    $program[] = explode(' ', trim($row));
}

$pointer = 0;
while (isset($program[$pointer])) {
    $instruction = $program[$pointer];
    switch ($instruction[0]) {
        case 'inc':
            $register[$instruction[1]]++;
            $pointer++;
            break;
        case 'dec':
            $register[$instruction[1]]--;
            $pointer++;
            break;
        case 'cpy':
            if (is_numeric($instruction[2])) {
                $pointer++;
                break;
            }
            $register[$instruction[2]] = is_numeric($instruction[1]) ? (int)$instruction[1] : $register[$instruction[1]];
            $pointer++;
            break;
        case 'jnz':
            if (!is_numeric($instruction[1]) && $register[$instruction[1]] === 0) {
                $pointer++;
            } else {
                if (is_numeric($instruction[2])) {
                    $pointer += $instruction[2];
                } else {
                    $pointer += $register[$instruction[2]];
                }
            }
            break;
        case 'tgl':
            $offset = is_numeric($instruction[1]) ? $instruction[1] : $register[$instruction[1]];
            if (!isset($program[$pointer + $offset])) {
                $pointer++;
                break;
            }
            if (count($program[$pointer + $offset]) === 2) {
                if ($program[$pointer + $offset][0] === 'inc') {
                    $program[$pointer + $offset][0] = 'dec';
                } else {
                    $program[$pointer + $offset][0] = 'inc';
                }
            } else if (count($program[$pointer + $offset]) === 3) {
                if ($program[$pointer + $offset][0] === 'jnz') {
                    $program[$pointer + $offset][0] = 'cpy';
                } else {
                    $program[$pointer + $offset][0] = 'jnz';
                }
            }
            $pointer++;
            break;
        default:
            throw new RuntimeException('Dude, WTF?! -- ' . print_r($program[$pointer], true));
    }
}

echo $register['a'], "\n";