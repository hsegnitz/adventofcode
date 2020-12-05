<?php

$program = [];
$register = [
    'a' => 0,
    'b' => 0,
    'c' => 0,
    'd' => 0,
];

foreach (file('./demo.txt') as $row) {
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
            $register[$instruction[2]] = is_numeric($instruction[1]) ? (int)$instruction[1] : $register[$instruction[1]];
            $pointer++;
            break;
        case 'jnz':
            if ($register[$instruction[1]] === 0) {
                $pointer++;
            } else {
                $pointer += $instruction[2];
            }
            break;
    }
}

echo $register['a'], "\n";