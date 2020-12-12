<?php

$startTime = microtime(true);

// $start = '..^^.';
// $start = '.^^.^.^^^^';
$start = '.^.^..^......^^^^^...^^^...^...^....^^.^...^.^^^^....^...^^.^^^...^^^^.^^.^.^^..^.^^^..^^^^^^.^^^..^';  // zeh real one

$field = [
    str_split($start),
];

function walk(array &$field) {
    $previous = $field[count($field)-1];
    $current = [];
    for ($i = 0, $iMax = count($previous); $i < $iMax; $i++) {
        $current[] = ackbar($previous, $i) ? '^' : '.';
    }
    $field[] = $current;
}

// as in "It's a trap!"
function ackbar(array $previous, int $pos): bool
{
    $segment = [
        $previous[$pos - 1] ?? '.',
        $previous[$pos],
        $previous[$pos + 1] ?? '.',
    ];

    return ($segment === ['^', '^', '.'] || $segment === ['.', '^', '^'] || $segment === ['^', '.', '.'] || $segment === ['.', '.', '^']);
}

function serializeField(array $field): string
{
    $ret = '';
    foreach ($field as $row) {
        $ret .= implode('', $row) . "\n";
    }
    return $ret;
}

while (count($field) < 400000) {
    walk($field);
}


$s = serializeField($field);
echo count_chars($s, 1)[46], "\n";  // 46 === '.'


echo "total time: ", (microtime(true) - $startTime), "\n";
