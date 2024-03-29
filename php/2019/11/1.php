<?php

namespace Y2019\D11;

$startTime = microtime(true);

include __DIR__ . '/../Instruction.php';
include __DIR__ . '/../IntCodeProgram.php';

enum Directions: string {
    case NORTH = "NORTH";
    case EAST  = "EAST";
    case SOUTH = "SOUTH";
    case WEST  = "WEST";
}


class Solver
{
    private array $input  = [3,8,1005,8,330,1106,0,11,0,0,0,104,1,104,0,3,8,102,-1,8,10,101,1,10,10,4,10,1008,8,0,10,4,10,102,1,8,29,2,9,4,10,1006,0,10,1,1103,17,10,3,8,102,-1,8,10,101,1,10,10,4,10,108,0,8,10,4,10,101,0,8,61,1006,0,21,1006,0,51,3,8,1002,8,-1,10,101,1,10,10,4,10,108,1,8,10,4,10,1001,8,0,89,1,102,19,10,1,1107,17,10,1006,0,18,3,8,1002,8,-1,10,1001,10,1,10,4,10,1008,8,1,10,4,10,1001,8,0,123,1,9,2,10,2,1105,10,10,2,103,9,10,2,1105,15,10,3,8,102,-1,8,10,1001,10,1,10,4,10,1008,8,0,10,4,10,102,1,8,161,3,8,102,-1,8,10,101,1,10,10,4,10,108,1,8,10,4,10,101,0,8,182,3,8,1002,8,-1,10,101,1,10,10,4,10,1008,8,0,10,4,10,101,0,8,205,2,1102,6,10,1006,0,38,2,1007,20,10,2,1105,17,10,3,8,102,-1,8,10,1001,10,1,10,4,10,108,1,8,10,4,10,1001,8,0,241,3,8,102,-1,8,10,101,1,10,10,4,10,108,1,8,10,4,10,101,0,8,263,1006,0,93,2,5,2,10,2,6,7,10,3,8,102,-1,8,10,101,1,10,10,4,10,108,0,8,10,4,10,1001,8,0,296,1006,0,81,1006,0,68,1006,0,76,2,4,4,10,101,1,9,9,1007,9,1010,10,1005,10,15,99,109,652,104,0,104,1,21102,825594262284,1,1,21102,347,1,0,1105,1,451,21101,0,932855939852,1,21101,358,0,0,1106,0,451,3,10,104,0,104,1,3,10,104,0,104,0,3,10,104,0,104,1,3,10,104,0,104,1,3,10,104,0,104,0,3,10,104,0,104,1,21102,1,235152649255,1,21101,405,0,0,1105,1,451,21102,235350879235,1,1,21102,416,1,0,1106,0,451,3,10,104,0,104,0,3,10,104,0,104,0,21102,988757512972,1,1,21101,439,0,0,1106,0,451,21102,1,988669698828,1,21101,0,450,0,1106,0,451,99,109,2,22101,0,-1,1,21102,40,1,2,21102,1,482,3,21102,472,1,0,1106,0,515,109,-2,2105,1,0,0,1,0,0,1,109,2,3,10,204,-1,1001,477,478,493,4,0,1001,477,1,477,108,4,477,10,1006,10,509,1101,0,0,477,109,-2,2106,0,0,0,109,4,1202,-1,1,514,1207,-3,0,10,1006,10,532,21102,1,0,-3,21202,-3,1,1,21202,-2,1,2,21102,1,1,3,21102,1,551,0,1106,0,556,109,-4,2105,1,0,109,5,1207,-3,1,10,1006,10,579,2207,-4,-2,10,1006,10,579,22101,0,-4,-4,1105,1,647,21201,-4,0,1,21201,-3,-1,2,21202,-2,2,3,21102,598,1,0,1105,1,556,21202,1,1,-4,21101,0,1,-1,2207,-4,-2,10,1006,10,617,21102,1,0,-1,22202,-2,-1,-2,2107,0,-3,10,1006,10,639,21202,-1,1,1,21102,1,639,0,105,1,514,21202,-2,-1,-2,22201,-4,-2,-4,109,-5,2105,1,0];

    private array $field = [];

    private array $seen = [];

    public function __construct()
    {
        for ($i = 0; $i < 200; $i++) {
            $this->field[] = array_fill(0, 200, 0);
        }

        $this->field[100][100] = 1;

        $program = new \IntCodeProgram($this->input);

        $posX = 100;
        $posY = 100;

        $heading = Directions::NORTH;

        $output = 0;
        while ($output !== -2) {
            $program->addInput($this->field[$posY][$posX]);

            $output = $program->run();
            if ($output < 0) {
                continue;
            }

            $this->field[$posY][$posX] = $output;

            $output = $program->run();
            if ($output < 0) {
                continue;
            }

            $this->seen["{$posX}:{$posY}"] = true;
            $heading = $this->turn($output, $heading);
            switch ($heading) {
                case Directions::NORTH: $posY--; break;
                case Directions::EAST:  $posX++; break;
                case Directions::SOUTH: $posY++; break;
                case Directions::WEST:  $posX--; break;
            }
        }

        echo count($this->seen);

        $this->printMap();
    }

    private function printMap(): void
    {
        foreach ($this->field as $row) {
            foreach ($row as $field) {
                echo $field === 0 ? ' ' : '#';
            }
            echo "\n";
        }
    }

    private function turn(int $command, Directions $current): Directions {
        if (1 === $command) {
            switch ($current) {
                case Directions::NORTH: return Directions::EAST;
                case Directions::EAST:  return Directions::SOUTH;
                case Directions::SOUTH: return Directions::WEST;
                case Directions::WEST:  return Directions::NORTH;
            }
        }
        switch ($current) {
            case Directions::NORTH: return Directions::WEST;
            case Directions::EAST:  return Directions::NORTH;
            case Directions::SOUTH: return Directions::EAST;
            case Directions::WEST:  return Directions::SOUTH;
        }
        throw new \Exception("<Shocko>Whaaaaaaaaa....???!!!!</Shocko>");
    }
}

new Solver();

echo "\ntotal time: ", number_format(microtime(true) - $startTime, 6), "\n";
