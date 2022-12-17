<?php

$startTime = microtime(true);

#$input = file_get_contents('./example.txt');
$input = file_get_contents('./in.txt');

$input = str_split($input);

$chute = [];

$rocks = [
    new Rock('H-Bar', [[0,0],[1,0],[2,0],[3,0]]),         // ####
    new Rock('Plus',  [[1,0],[0,1],[1,1],[2,1],[1,2]]),   // +
    new Rock('Rev-L', [[2,2],[2,1],[0,0],[1,0],[2,0]]),   // _|
    new Rock('Pipe',  [[0,0],[0,1],[0,2],[0,3]]),         // |
    new Rock('Block', [[0,0],[1,0],[0,1],[1,1]]),         // #
];



$steps = $numParts = 0;
$maxY = -1;

#while ($numParts <= 2) {
while ($numParts < 2022) {
    $rock = $rocks[($numParts++ % count($rocks))];
    #echo $rock->name, ': ';
    $rock->setCoordinates(2, $maxY + 4);
    while (true) {
        $push = $input[($steps++ % count($input))];
        #echo $push;
        $rock->push($push, $chute);
        if (!$rock->fall($chute)) {
            $maxY = max($maxY, $rock->maxYForRock);
            #debugPrint($maxY, $chute);
            #echo "\n";
            continue 2;
        }
    }
}




class Rock {
    private int $x;
    private int $y;

    private int $width;

    public int $maxYForRock;

    /** int[][] -- pairs of offsets [x,y] */
    public function __construct(public readonly string $name, private readonly array $relativeCoordinates) {
        $this->width  = max(array_column($this->relativeCoordinates, 0)) + 1;
    }

    /** sets coord of "left bottom" of the Rock */
    public function setCoordinates(int $x, int $y): void {
        $this->x = $x;
        $this->y = $y;
        $this->maxYForRock = PHP_INT_MIN;
    }

    public function push(string $direction, array $chute): void {
        if ('<' === $direction && $this->x > 0) {
            $this->x--;
            if ($this->isCollision($chute)) {
                $this->x++;
            }
        }
        if ('>' === $direction && ($this->x + $this->width) < 7) {
            $this->x++;
            if ($this->isCollision($chute)) {
                $this->x--;
            }
        }
    }

    public function fall(array &$chute): bool {
        $this->y--;
        if ($this->y < 0 || $this->isCollision($chute)) {
            $this->y++;
            $this->paint($chute);
            return false;
        }
        return true;
    }

    private function paint(array &$chute): void {
        foreach ($this->relativeCoordinates as $coordinate) {
            $new = (string)($this->x + $coordinate[0]) . 'x' . (string)($this->y + $coordinate[1]);
            $this->maxYForRock = max($this->maxYForRock, $this->y + $coordinate[1]);
            $chute[$new] = '#';
        }
    }

    private function isCollision(array $chute): bool
    {
        foreach ($this->relativeCoordinates as $coordinate) {
            $toCheck = (string)($this->x + $coordinate[0]) . 'x' . (string)($this->y + $coordinate[1]);
            if (isset($chute[$toCheck])) {
                return true;
            }
        }
        return false;
    }
}


#print_r($chute);

$ys = [];
foreach (array_keys($chute) as $coordinate) {
    [, $coord] = explode('x', $coordinate);
    $ys[] = $coord;
}

$height = max($ys)+1;

function debugPrint(int $maxY, array $chute): void {
    for ($y = $maxY+3; $y >= 0; $y--) {
        for ($x = 0; $x < 7; $x++) {
            echo isset($chute["{$x}x{$y}"]) ? '#' : '.';
        }
        echo "\n";
    }
    echo "\n";
}




echo "Part 1: ", $height;

echo "\ntotal time: ", (microtime(true) - $startTime), "\n";

