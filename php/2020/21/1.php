<?php

$startTime = microtime(true);

$input = [];
foreach (file(__DIR__ . '/in.txt') as $row) {
    [$ingredients, $allergens] = explode(' (contains ', substr(trim($row), 0, -1));
    $input[] = [
        'ingredients' => explode(' ', $ingredients),
        'allergens'   => explode(', ', $allergens),
    ];
}

$seenAllergens = [];
$candidatesPerAllergen = [];
$ingredientCount = [];
foreach ($input as $row) {
    foreach ($row['ingredients'] as $ingredient) {
        if (!isset($ingredientCount[$ingredient])) {
            $ingredientCount[$ingredient] = 0;
        }
        ++ $ingredientCount[$ingredient];
    }
    foreach ($row['allergens'] as $allergen) {
        if (!isset($seenAllergens[$allergen])) {
            $seenAllergens[$allergen] = 1;
            $candidatesPerAllergen[$allergen] = $row['ingredients'];
        } else {
            $candidatesPerAllergen[$allergen] = array_intersect($candidatesPerAllergen[$allergen], $row['ingredients']);
        }
    }
}

print_r($candidatesPerAllergen);

$knownAllergens = [];
while (count($knownAllergens) !== count($candidatesPerAllergen)) {
    foreach ($candidatesPerAllergen as $all => $ingrs) {
        if (isset($knownAllergens[$all])) {
            continue;
        }
        $left = array_diff($ingrs, $knownAllergens);
        if (count($left) === 1) {
            $knownAllergens[$all] = array_pop($left);
        }
    }
}

print_r($knownAllergens);

$safeIngrCounts = $ingredientCount;
foreach ($knownAllergens as $all => $ingr) {
    unset($safeIngrCounts[$ingr]);
}

echo "Part 1: ", array_sum($safeIngrCounts), "\n";

ksort($knownAllergens);

echo "Part 2: ", implode(",", $knownAllergens);


echo "\ntotal time: ", (microtime(true) - $startTime), "\n";
