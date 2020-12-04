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

    public function isValidDay1(): bool
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
}