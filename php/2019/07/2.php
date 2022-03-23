<?php

$startTime = microtime(true);

include __DIR__ . '/../Instruction.php';
include __DIR__ . '/../IntCodeProgram.php';

$small0 = [3,26,1001,26,-4,26,3,27,1002,27,2,27,1,27,26,27,4,27,1001,28,-1,28,1005,28,6,99,0,0,5];
$small1 = [3,52,1001,52,-5,52,3,53,1,52,56,54,1007,54,5,55,1005,55,26,1001,54,-5,54,1105,1,12,1,53,54,53,1008,54,0,55,1001,55,1,55,2,53,55,53,4,53,1001,56,-1,56,1005,56,6,99,0,0,0,0,10];
$input  = [3,8,1001,8,10,8,105,1,0,0,21,46,55,72,85,110,191,272,353,434,99999,3,9,1002,9,5,9,1001,9,2,9,102,3,9,9,101,2,9,9,102,4,9,9,4,9,99,3,9,102,5,9,9,4,9,99,3,9,1002,9,2,9,101,2,9,9,1002,9,2,9,4,9,99,3,9,1002,9,4,9,101,3,9,9,4,9,99,3,9,1002,9,3,9,101,5,9,9,1002,9,3,9,101,3,9,9,1002,9,5,9,4,9,99,3,9,1001,9,2,9,4,9,3,9,101,2,9,9,4,9,3,9,101,2,9,9,4,9,3,9,1001,9,2,9,4,9,3,9,102,2,9,9,4,9,3,9,102,2,9,9,4,9,3,9,102,2,9,9,4,9,3,9,1002,9,2,9,4,9,3,9,102,2,9,9,4,9,3,9,1002,9,2,9,4,9,99,3,9,102,2,9,9,4,9,3,9,102,2,9,9,4,9,3,9,1001,9,1,9,4,9,3,9,1001,9,1,9,4,9,3,9,1002,9,2,9,4,9,3,9,1001,9,2,9,4,9,3,9,102,2,9,9,4,9,3,9,101,1,9,9,4,9,3,9,1001,9,1,9,4,9,3,9,101,2,9,9,4,9,99,3,9,1002,9,2,9,4,9,3,9,1001,9,2,9,4,9,3,9,101,2,9,9,4,9,3,9,1001,9,1,9,4,9,3,9,1002,9,2,9,4,9,3,9,1001,9,1,9,4,9,3,9,1001,9,1,9,4,9,3,9,1001,9,2,9,4,9,3,9,1001,9,1,9,4,9,3,9,101,2,9,9,4,9,99,3,9,1001,9,2,9,4,9,3,9,102,2,9,9,4,9,3,9,101,2,9,9,4,9,3,9,1001,9,2,9,4,9,3,9,1001,9,2,9,4,9,3,9,1002,9,2,9,4,9,3,9,102,2,9,9,4,9,3,9,1002,9,2,9,4,9,3,9,1002,9,2,9,4,9,3,9,1001,9,1,9,4,9,99,3,9,101,1,9,9,4,9,3,9,102,2,9,9,4,9,3,9,102,2,9,9,4,9,3,9,1001,9,2,9,4,9,3,9,1002,9,2,9,4,9,3,9,1002,9,2,9,4,9,3,9,102,2,9,9,4,9,3,9,102,2,9,9,4,9,3,9,1001,9,2,9,4,9,3,9,1001,9,2,9,4,9,99];

class Solver
{
    public function __construct(private array $program)
    {
        $max = PHP_INT_MIN;

        foreach ($this->permutations([5, 6, 7, 8, 9]) as $phaseSettings) {
            $progs = $this->getNewPrograms($phaseSettings);

            $prevResult = 0;
            $outputCandidate = 0;
            while ($prevResult > -1) {
                foreach ($progs as $prog) {
                    $prog->addInput($prevResult);
                    $prevResult = $prog->run();
                    if ($prevResult === -1) {
                        break;
                    }
                }
                if ($prevResult !== -1) {
                    $outputCandidate = $prevResult;
                }
            }
            $max = max($max, $outputCandidate);
        }
        echo $max;
    }


    private function getNewPrograms(array $phaseSettings): array {
        $programs = [];
        $a = new IntCodeProgram($this->program); $a->addInput($phaseSettings[0]); $programs[] = $a;
        $b = new IntCodeProgram($this->program); $b->addInput($phaseSettings[1]); $programs[] = $b;
        $c = new IntCodeProgram($this->program); $c->addInput($phaseSettings[2]); $programs[] = $c;
        $d = new IntCodeProgram($this->program); $d->addInput($phaseSettings[3]); $programs[] = $d;
        $e = new IntCodeProgram($this->program); $e->addInput($phaseSettings[4]); $programs[] = $e;
        return $programs;
    }


    private function permutations(array $elements): Generator
    {
        if (count($elements) <= 1) {
            yield $elements;
        } else {
            foreach ($this->permutations(array_slice($elements, 1)) as $permutation) {
                foreach (range(0, count($elements) - 1) as $i) {
                    yield array_merge(
                        array_slice($permutation, 0, $i),
                        [$elements[0]],
                        array_slice($permutation, $i)
                    );
                }
            }
        }
    }
}

$solver = new solver($input);


echo "\ntotal time: ", number_format(microtime(true) - $startTime, 6), "\n";
