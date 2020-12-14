<?php

$startTime = microtime(true);

//$seed = 'ihgpwlah';
//$seed = 'kglvqrro';
//$seed = 'ulqzkmiv';
$seed = 'lpvhkcbi';  // zeh real one

class maze
{
    private const OPEN = 'bcdef';

    private array $paths = [];

    public function walk(string $passcode, string $path, int $x, int $y): ?int
    {
        if ($x === 3 && $y === 3) {
            $this->paths[] = $path;
            return strlen($path);
        }

        $md5 = md5($passcode . $path);
        $results = [];
        if ($y > 0 && false !== strpos(self::OPEN, $md5[0]) && null !== ($result = $this->walk($passcode, $path.'U', $x, $y-1))) {
            $results[] = $result;
        }

        if ($y < 3 && false !== strpos(self::OPEN, $md5[1]) && null !== ($result = $this->walk($passcode, $path.'D', $x, $y+1))) {
            $results[] = $result;
        }

        if ($x > 0 && false !== strpos(self::OPEN, $md5[2]) && null !== ($result = $this->walk($passcode, $path.'L', $x-1, $y))) {
            $results[] = $result;
        }

        if ($x < 3 && false !== strpos(self::OPEN, $md5[3]) && null !== ($result = $this->walk($passcode, $path.'R', $x+1, $y))) {
            $results[] = $result;
        }

        if ($results === []) {
            return null; // dead end
        }

        return max($results);
    }

    public function getPathByLength(int $length): string
    {
        foreach ($this->paths as $path) {
            if (strlen($path) === $length) {
                return $path;
            }
        }
        return 'nothing found!';
    }

}

$maze = new maze();
echo $shortestLength = $maze->walk($seed, '', 0, 0), "\n";
echo $maze->getPathByLength($shortestLength), "\n";

echo "total time: ", (microtime(true) - $startTime), "\n";
