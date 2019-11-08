<?php

include '../vendor/autoload.php';

$job = 'php -f worker.php ';

$dispatcher = new \FastBill\ParallelProcessDispatcher\Dispatcher(12);

for ($x = 1; $x <= 300; $x++) {
    $process = new \FastBill\ParallelProcessDispatcher\Process($job . $x);
    $dispatcher->addProcess($process);
}

$dispatcher->dispatch(100000);

$results = [];
foreach ($dispatcher->getFinishedProcesses() as $job) {
    $results[] = $job->getOutput();
}

sort($results);

print_r($results);
