<?php

$startTime = microtime(true);

class Recipe {
    private function __construct(
        private string $outputType,
        private int $outputQuantity,
        private array $requirements,
    ) {}

    public static function fromString(string $raw): Recipe
    {
        $fls = explode(' => ', $raw);
        $sls = explode(', ', $fls[0]);

        $reqs = [];
        foreach ($sls as $req) {
            [$a, $b] = explode(' ', $req);
            $reqs[$b] = $a;
        }

        [$a, $b] = explode(' ', $fls[1]);

        return new self($b, $a, $reqs);
    }

    /**
     * @return string
     */
    public function getOutputType(): string
    {
        return $this->outputType;
    }

    /**
     * @return int
     */
    public function getOutputQuantity(): int
    {
        return $this->outputQuantity;
    }

    /**
     * @return array
     */
    public function getRequirements(): array
    {
        return $this->requirements;
    }
}

$input = file('./small1.txt', FILE_IGNORE_NEW_LINES);
//$input = file('./small2.txt', FILE_IGNORE_NEW_LINES);
//$input = file('./small3.txt', FILE_IGNORE_NEW_LINES);
//$input = file('./small4.txt', FILE_IGNORE_NEW_LINES);
//$input = file('./small5.txt', FILE_IGNORE_NEW_LINES);
//$input = file('./in.txt', FILE_IGNORE_NEW_LINES);

$recipes = [];
foreach ($input as $line) {
    if (trim($line) !== '') {
        $recipe = Recipe::fromString($line);
        if (isset($recipes[$recipe->getOutputType()])) {
            throw new RuntimeException('duplicate found :(');
        }
        $recipes[$recipe->getOutputType()] = $recipe;
    }
}

$inventoryOfNeeds = ['FUEL' => 1];
$excessAmounts = [];

while (count($inventoryOfNeeds) > 1 || !isset($inventoryOfNeeds['ORE'])) {
    $newNeeds = [];
    foreach ($inventoryOfNeeds as $need => $quantityOfNeed) {
        if ($need === 'ORE') {
            $newNeeds['ORE'] = $quantityOfNeed;
            continue;
        }
        $recipe = $recipes[$need];

        if (isset($excessAmounts[$need])) {
            $quantityOfNeed -= $excessAmounts[$need];
            unset($excessAmounts[$need]);
        }

        $runs = (int)ceil($quantityOfNeed / $recipe->getOutputQuantity());

        $producedAmount = $runs * $recipe->getOutputQuantity();
        if (!isset($excessAmounts[$need])) {
            $excessAmounts[$need] = 0;
        }
        $excessAmounts[$need] += $producedAmount - $quantityOfNeed;

        foreach ($recipe->getRequirements() as $type => $quant) {
            if (!isset($newNeeds[$type])) {
                $newNeeds[$type] = 0;
            }
            $newNeeds[$type] += $quant * $runs;
        }
    }
    $inventoryOfNeeds = $newNeeds;
}

echo $inventoryOfNeeds['ORE'];

echo "\ntotal time: ", number_format(microtime(true) - $startTime, 6), "\n";
