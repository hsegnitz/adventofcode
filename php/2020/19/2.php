<?php

$startTime = microtime(true);

$rawInput = file_get_contents(__DIR__ . '/in.txt');
$input = explode("\n\n", $rawInput);

// apply patch from story
$input[0] = str_replace(
    ['8: 42', '11: 42 31'],
    ['8: ( 42 ) +', '11: 42 {1} 31 {1} | 42 {2} 31 {2} | 42 {3} 31 {3} | 42 {4} 31 {4} | 42 {5} 31 {5}'],
    $input[0]
);


$rawRules = explode("\n", $input[0]);
$rawMessages = explode("\n", $input[1]);

$rules = [];
foreach ($rawRules as $line) {
    $split = explode(': ', $line);
    $rules[$split[0]] = explode(' ', $split[1]);
    if (preg_match('/\"(.)\"/', $split[1], $out)) {
        $rules[$split[0]] = [$out[1]];
    }
}

class Rule {
    /** @var Rule[] */
    public static array $allRules = [];

    private array $ruleSet = [];

    public function __construct(array $ruleSet)
    {
        $this->ruleSet = $ruleSet;
    }

    public function __toString(): string
    {
        $str = '';
        foreach($this->ruleSet as $rule) {
            if (is_numeric($rule)) {
                $str .= self::$allRules[$rule];
            } else {
                $str .= $rule;
            }
        }

        if (in_array('|', $this->ruleSet, true)) {
            return '(' . $str . ')';
        }
        return $str;
    }
}

foreach ($rules as $k => $rule) {
    Rule::$allRules[$k] = new Rule($rule);
}

echo $regex = '/^' . Rule::$allRules[0] . '$/', "\n";

$count = 0;
foreach ($rawMessages as $message) {
    if (preg_match($regex, $message)) {
        ++$count;
    }
}

echo $count;

#print_r($rules);





echo "\ntotal time: ", (microtime(true) - $startTime), "\n";
