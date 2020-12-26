<?php

class GarbageGourmet
{
    private $stream;

    public function __construct(string $stream)
    {
        // remove negators
        $stream = preg_replace('/!./', '', $stream);
        $stream = preg_replace('/<[^>]*>/', '', $stream);
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
}
