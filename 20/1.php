<?php

ini_set('xdebug.max_nesting_level', 512);

class room
{
    /** @var int[] */
    private $seen = [];

    /**
     * Whenever we reach a tile we have seen already, we check if we had a shorter way to it before.
     * If so, we return the short distance and continue counting from there. If the new path is
     * short than the previous one, we update the value and return it.
     *
     * This way we eliminate "immediate continue branches", short loops "WESN" and even longer loops
     *
     * @param  int $x
     * @param  int $y
     * @param  int $distance
     * @return int
     */
    private function registerAsSeen($x, $y, $distance)
    {
        $key = "{$x}x{$y}";
        if (! isset($this->seen[$key])) {
            $this->seen[$key] = $distance;
        }

        $this->seen[$key] = min($distance, $this->seen[$key]);
        return $this->seen[$key];
    }

    /**
     * @param string $in
     */
    public function walk($x, $y, $dist, $in)
    {
        $dist = $this->registerAsSeen($x, $y, $dist);

        $len = strlen($in);
        for ($i = 0; $i < $len; $i++) {
            switch ($in[$i]) {
                case '$':
                    return;
                case 'N':
                    $dist = $this->registerAsSeen($x, --$y, ++$dist);
                    break;
                case 'E':
                    $dist = $this->registerAsSeen(++$x, $y, ++$dist);
                    break;
                case 'S':
                    $dist = $this->registerAsSeen($x, ++$y, ++$dist);
                    break;
                case 'W':
                    $dist = $this->registerAsSeen(--$x, $y, ++$dist);
                    break;
                case '(':
                    $remainder = substr($in, $i);
                    $posClosingBrace = $this->findClosingParanthesis($remainder);
                    $branches = $this->splitWithBraces(substr($remainder, 1, $posClosingBrace-1));
                    foreach ($branches as $branch) {
                        $this->walk($x, $y, $dist, $branch . substr($remainder, $posClosingBrace+1));
                    }
                    return;
                default:
                    throw new RuntimeException('Go fuck yourself with your ' . $in[$i]);
            }
        }
    }

    /**
     * @param  string   $in
     * @return string[]
     */
    private function splitWithBraces($in)
    {
        $pattern = '/\(([^\(\)]+)\)/';
        while (true) {
            $newIn = preg_replace_callback($pattern, function ($matches) {return '[' . str_replace('|', '-', $matches[1]) . ']';}, $in);
            if ($newIn === $in) {
                break;
            }
            $in = $newIn;
        }

        $out = [];
        foreach (explode('|', $newIn) as $row) {
            $out[] = str_replace(['[', '-', ']'], ['(', '|', ')'], $row);
        }

        return $out;
    }

    /**
     * @param  string $in
     * @return int
     */
    private function findClosingParanthesis($in)
    {
        $count = 0;
        $len = strlen($in);
        for ($i = 0; $i < $len; $i++) {
            if ($in[$i] === '(') {
                ++$count;
            } elseif ($in[$i] === ')') {
                --$count;
            }

            if ($count === 0) {
                return $i;
            }
        }
    }

    public function getSeen()
    {
        return $this->seen;
    }
}

$in = file_get_contents('in.txt');

// cleanup superfluous walkthroughs
$dictionary = [
    '(|'   => '(',
    '||'   => '|',
    '|)'   => ')',
    '()'   => '',
    'NWES' => '',
    'NWSE' => '',
    'NEWS' => '',
    'NESW' => '',
    'NSEW' => '',
    'NSWE' => '',
    'WNES' => '',
    'WNSE' => '',
    'WESN' => '',
    'WENS' => '',
    'WSNE' => '',
    'WSEN' => '',
    'EWSN' => '',
    'EWNS' => '',
    'ENSW' => '',
    'ENWS' => '',
    'ESWN' => '',
    'ESNW' => '',
    'SEWN' => '',
    'SENW' => '',
    'SWEN' => '',
    'SWNE' => '',
    'SNWE' => '',
    'SNEW' => '',
];

while (true) {
    $newIn = str_replace(array_keys($dictionary), array_values($dictionary), $in);
    if ($newIn === $in) {
        break;
    }
    $in = $newIn;
}

#echo $in, "   ", strlen($in);

#die();

$root = new room();
$root->walk(0, 0, 0, substr($in, 1));
echo max($root->getSeen()), "\n\n";
print_r($root->getSeen());

