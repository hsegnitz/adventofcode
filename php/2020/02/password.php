<?php

class password
{
    const RECEIVE_REGEX = '/(\d+)-(\d+) (\w): (.+)/';

    private string $password;
    private int $lower;
    private int $upper;
    private string $character;

    public function __construct(string $rawInput)
    {
        if (!preg_match(self::RECEIVE_REGEX, $rawInput, $out)) {
            throw new RuntimeException('cannot read input: ' . $rawInput);
        }

        [, $this->lower, $this->upper, $this->character, $this->password] = $out;
    }

    /**
     * Day 1
     */
    public function isValidAtSledRental(): bool
    {
        $filtered = preg_replace(
            '/[^' . $this->character . ']/',
            '',
            $this->password
        );

        return $this->lower <= strlen($filtered) && $this->upper >= strlen($filtered);
    }

    /**
     * Day 2
     */
    public function isValidInToboggan(): bool
    {
        if (strlen($this->password) < $this->lower) {
            return false;
        }

        if (strlen($this->password) < $this->upper) {
            return false;
        }

        $firstCharMatches  = $this->password[$this->lower - 1] === $this->character;
        $secondCharMatches = $this->password[$this->upper - 1] === $this->character;

        return $firstCharMatches xor $secondCharMatches;
    }
}
