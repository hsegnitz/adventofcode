<?php

$startTime = microtime(true);

#$input = file('./example.txt', FILE_IGNORE_NEW_LINES);
$input = file('./in.txt', FILE_IGNORE_NEW_LINES);

$rawMonkeys = [];
foreach ($input as $row) {
    $split = explode(': ', $row);
    $rawMonkeys[$split[0]] = $split[1];
}

while ($rawMonkeys !== []) {
    $newRawMonkeys = [];
    foreach ($rawMonkeys as $name => $rawMonkey) {
        if (($monkey = Monkey::factory($rawMonkey)) === null) {
            $newRawMonkeys[$name] = $rawMonkey;
            continue;
        }
        Monkey::$monkeys[$name] = $monkey;
    }

    $rawMonkeys = $newRawMonkeys;
}



abstract class Monkey {
    /** @var Monkey[] */
    public static array $monkeys = [];

    abstract public function result(): int;

    public static function factory(string $monkeyDef): ?Monkey {
        if (is_numeric($monkeyDef)) {
            return self::forNumber((int)$monkeyDef);
        }

        $split = explode(' ', $monkeyDef);
        if (!isset(self::$monkeys[$split[0]], self::$monkeys[$split[2]])) {
            return null;
        }
        return self::forOperator($split[1], self::$monkeys[$split[0]], self::$monkeys[$split[2]]);
    }

    private static function forNumber(int $number): NumberMonkey {
        return new NumberMonkey($number);
    }

    private static function forOperator(string $operator, Monkey $left, Monkey $right): Monkey {
        return match ($operator) {
            '+' => new AddMonkey($left, $right),
            '-' => new SubMonkey($left, $right),
            '/' => new DivMonkey($left, $right),
            '*' => new MulMonkey($left, $right),
            default => throw new RuntimeException('kemma nich!'),
        };
    }
}

class NumberMonkey extends Monkey {
    public function __construct(private int $number) {}

    public function result(): int {
        return $this->number;
    }
}

class AddMonkey extends Monkey {
    public function __construct(private Monkey $left, private Monkey $right) {}

    public function result(): int {
        return $this->left->result() + $this->right->result();
    }
}

class MulMonkey extends Monkey {
    public function __construct(private Monkey $left, private Monkey $right) {}

    public function result(): int {
        return $this->left->result() * $this->right->result();
    }
}

class DivMonkey extends Monkey {
    public function __construct(private Monkey $left, private Monkey $right) {}

    public function result(): int {
        return $this->left->result() / $this->right->result();
    }
}

class SubMonkey extends Monkey {
    public function __construct(private Monkey $left, private Monkey $right) {}

    public function result(): int {
        return $this->left->result() - $this->right->result();
    }
}




echo "Part 1: ", Monkey::$monkeys['root']->result();

echo "\ntotal time: ", (microtime(true) - $startTime), "\n";

