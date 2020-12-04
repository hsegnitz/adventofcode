<?php

class passport
{
    private ?string $birthYear = null;
    private ?string $issueYear = null;
    private ?string $expirationYear = null;
    private ?string $height = null;
    private ?string $hairColor = null;
    private ?string $eyeColor = null;
    private ?string $passportId = null;
    private ?string $countryId = null;

    public function __construct(string $rawInput)
    {
        $kvPairs = preg_split('/[\s]+/', $rawInput);
        foreach ($kvPairs as $pair) {
            [$key, $value] = explode(':', $pair);
            switch ($key) {
                case 'byr': $this->birthYear      = $value; break;
                case 'iyr': $this->issueYear      = $value; break;
                case 'eyr': $this->expirationYear = $value; break;
                case 'hgt': $this->height         = $value; break;
                case 'hcl': $this->hairColor      = $value; break;
                case 'ecl': $this->eyeColor       = $value; break;
                case 'pid': $this->passportId     = $value; break;
                case 'cid': $this->countryId      = $value; break;
                default: throw new InvalidArgumentException('unknown field ' . $key);
            }
        }
    }

    public function isValid1(): bool
    {
        if (null === $this->birthYear) {
            return false;
        }

        if (null === $this->issueYear) {
            return false;
        }

        if (null === $this->expirationYear) {
            return false;
        }

        if (null === $this->height) {
            return false;
        }

        if (null === $this->hairColor) {
            return false;
        }

        if (null === $this->eyeColor) {
            return false;
        }

        if (null === $this->passportId) {
            return false;
        }

        return true;
    }

    public function isValid2(): bool
    {
        if (!preg_match('/^\d{4}$/', $this->birthYear) || 1920 > $this->birthYear || 2002 < $this->birthYear) {
            return false;
        }

        if (!preg_match('/^\d{4}$/', $this->issueYear) || 2010 > $this->issueYear || 2020 < $this->issueYear) {
            return false;
        }

        if (!preg_match('/^\d{4}$/', $this->expirationYear) || 2020 > $this->expirationYear || 2030 < $this->expirationYear) {
            return false;
        }

        if (!preg_match('/(\d+)(cm|in)/', $this->height, $heightOut) || ($heightOut[2] === 'cm' && (150 > $heightOut[1] || 193 < $heightOut[1])) || ($heightOut[2] === 'in' && (59 > $heightOut[1] || 76 < $heightOut[1]))) {
            return false;
        }

        if (!preg_match('/^#[0-9a-f]{6}$/', $this->hairColor)) {
            return false;
        }

        if (!in_array($this->eyeColor, ['amb', 'blu', 'brn', 'gry', 'grn', 'hzl', 'oth'])) {
            return false;
        }

        if (!preg_match('/^[\d]{9}$/', $this->passportId)) {
            return false;
        }

        return true;
    }
}