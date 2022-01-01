<?php

$startTime = microtime(true);

#$input = file_get_contents('./demo.txt');
#$order = implode('', range('a', 'e'));
$input = file_get_contents('./in.txt');
$order = implode('', range('a', 'p'));

$input = explode(',', $input);


foreach ($input as $statement) {
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

echo $order;


echo "\ntotal time: ", number_format(microtime(true) - $startTime, 6), "\n";


