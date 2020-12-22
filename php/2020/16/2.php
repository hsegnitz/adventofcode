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

    public function getFieldName(): string
    {
        return $this->fieldName;
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

    public function getNumberAtPosition(int $pos): int
    {
        return $this->numbers[$pos];
    }

    public function getFieldCount(): int
    {
        return count($this->numbers);
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

$validTickets = [];
foreach ($otherTickets as $ticket) {
    if ([] === $ticket->getInvalidValues($rules)) {
        $validTickets[] = $ticket;
    }
}

$ruleForColumn = [];
$uncheckedColumns = range(0, $validTickets[0]->getFieldCount() - 1);

while (count($uncheckedColumns)) {
    foreach ($uncheckedColumns as $col) {
        $validRulesForCol = [];
        foreach ($rules as $ruleKey => $rule) {
            foreach ($validTickets as $validTicket) {
                if (!$rule->isValidNumber($validTicket->getNumberAtPosition($col))) {
                    continue 2;
                }
            }
            $validRulesForCol[$ruleKey] = $rule;
        }
        if (count($validRulesForCol) > 1) {
            continue;
        }
        if (count($validRulesForCol) === 0) {
           throw new RuntimeException('no rule matches? we\'re doomed!');
        }
        unset($uncheckedColumns[$col]);
        foreach ($validRulesForCol as $k => $v) {  // 1 element, but we need the key
            $ruleForColumn[$col] = $v;
            unset ($rules[$k]);
        }
    }
}

#print_r($ruleForColumn);
$nums = [];
/**
 * @var int $col
 * @var Rule $rule
 */
foreach ($ruleForColumn as $col => $rule) {
    if (0 !== strpos($rule->getFieldName(), 'departure')) {
        continue;
    }
    $nums[] = $myTicket->getNumberAtPosition($col);
}

echo array_reduce($nums, function (int $carry, int $value) { return $carry * $value; }, 1);

echo "\ntotal time: ", (microtime(true) - $startTime), "\n";
