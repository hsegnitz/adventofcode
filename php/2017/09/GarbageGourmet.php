<?php

class GarbageGourmet
{
    private $stream;
    private $garbageSize = 0;

    public function __construct(string $stream)
    {
        // remove negators
        $stream = preg_replace('/!./', '', $stream);
        $before = strlen($stream);
        $count = 0;
        $stream = preg_replace('/<[^>]*>/', '', $stream, -1, $count);
        $this->garbageSize = $before - strlen($stream) - (2 * $count);
        $this->stream = str_replace(',', '', $stream);
        #echo $this->stream, "\n";
    }

    public function score(): int
    {
        $depth = 0; $score = 0;
        $split = str_split($this->stream);

        while (null !== ($cur = array_shift($split))) {
            if ($cur === '{') {
                ++$depth;
            }
            if ($cur === '}') {
                $score += $depth;
                --$depth;
            }
        }
        return $score;
    }

    public function getGarbageSize(): int
    {
        return $this->garbageSize;
    }
}
