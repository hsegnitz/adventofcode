<?php

$startTime = microtime(true);

#$input = file_get_contents('./demo.txt');
#$order = implode('', range('a', 'e'));
$input = file_get_contents('./in.txt');
$originalOrder = $order = implode('', range('a', 'p'));

$input = explode(',', $input);

$seen = [$order => true];

function dance(string $order, array $moves) : string
{
    foreach ($moves as $statement) {
        switch ($statement[0]) {
            case 's':
                $position = substr($statement, 1);
                $order = substr($order, $position * -1) . substr($order, 0, $position * -1);
                break;
            case 'x':
                [$a, $b] = explode('/', substr($statement, 1));
                $a = (int)$a;
                $b = (int)$b;
                $disorder = $order;
                $order[$a] = $disorder[$b];
                $order[$b] = $disorder[$a];
                break;
            case 'p':
                [$a, $b] = explode('/', substr($statement, 1));
                $a = strpos($order, $a);
                $b = strpos($order, $b);
                $disorder = $order;
                $order[$a] = $disorder[$b];
                $order[$b] = $disorder[$a];

                break;
            default;
                throw new RuntimeException('<shocko>Whaaaaaaaa......?</shocko>');
        }
    }
    return $order;
}

for ($i = 0; $i < 1000000000; $i++) {
    $order = dance($order, $input);
    if (isset($seen[$order])) {
        echo $repeat = count($seen), "\n";
        break;
    }
    $seen[$order] = true;
}

$extraRounds = 1000000000 % $repeat;
for ($i = 0; $i < $extraRounds; $i++) {
    $originalOrder = dance($originalOrder, $input);
}

echo $originalOrder;


echo "\ntotal time: ", number_format(microtime(true) - $startTime, 6), "\n";


