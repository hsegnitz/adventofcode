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

    public function isValid(): bool
    {
        $filtered = preg_replace(
            '/[^' . $this->character . ']/',
            '',
            $this->password
        );

        return $this->lower <= strlen($filtered) && $this->upper >= strlen($filtered);
    }
}
