<?php

$startTime = microtime(true);

$input = file_get_contents(__DIR__ . '/in.txt');

[$rawRules, $myRawTicket, $otherRawTickets] = explode("\n\n", $input);

$rawRules        = explode("\n", $rawRules);
$myRawTicket     = explode("\n", $myRawTicket)[1];
$otherRawTickets = explode("\n", $otherRawTickets);

array_shift($otherRawTickets);

class Rule
{
    private array $ranges;
    private string $fieldName;

    public function __construct(string $input)
    {
        if (!preg_match("/^([^:]+): (\d+)-(\d+) or (\d+)-(\d+)$/", $input, $out)) {
            throw new RuntimeException('WTF?! ' . $input);
        }
        $this->fieldName = $out[1];
        $this->ranges = [
            ['lower' => $out[2], 'upper' => $out[3], ],
            ['lower' => $out[4], 'upper' => $out[5], ],
        ];
    }

    public function isValidNumber(int $number): bool
    {
        foreach ($this->ranges as $range) {
            if ($number <= $range['upper'] && $number >= $range['lower']) {
                return true;
            }
        }
        return false;
    }
}

class Ticket
{
    private array $numbers;

    public function __construct(string $input)
    {
        $this->numbers = explode(",", $input);
        array_walk($this->numbers, static function (&$value) { $value = (int)$value; });
    }

    /**
     * @param  Rule[] $rules
     * @return int[]
     */
    public function getInvalidValues(array $rules): array
    {
        $errors = [];
        foreach ($this->numbers as $number) {
            foreach ($rules as $rule) {
                if ($rule->isValidNumber($number)) {
                    continue 2;
                }
            }
            $errors[] = $number;
        }
        return $errors;
    }


}

$rules = [];
foreach ($rawRules as $rawRule) {
    $rules[] = new Rule($rawRule);
}

$otherTickets = [];
foreach ($otherRawTickets as $otherRawTicket) {
    $otherTickets[] = new Ticket($otherRawTicket);
}

$myTicket = new Ticket($myRawTicket);

$errors = [];
foreach ($otherTickets as $ticket) {
    $errors = array_merge($errors, $ticket->getInvalidValues($rules));
}

echo array_sum($errors);


echo "\ntotal time: ", (microtime(true) - $startTime), "\n";

