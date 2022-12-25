<?php

$startTime = microtime(true);

#$input = file('./example0.txt', FILE_IGNORE_NEW_LINES);
#$input = file('./example.txt', FILE_IGNORE_NEW_LINES);
$input = file('./in.txt', FILE_IGNORE_NEW_LINES);

$sum = 0;
foreach ($input as $snafu) {
    echo $snafu, ': ', ($dec = Snafu::toDecimal($snafu)), "\n";
    $sum += $dec;
}

echo "Sum decimal: ", $sum, "\n";

class Snafu {
    public static function toDecimal(string $snafu): int {
        #transpose to base5
        $dec = str_replace(
            ['2', '1', '0', '-', '='],
            ['4', '3', '2', '1', '0'],
            $snafu
        );

        #translate to decimal
        $dec = base_convert($dec, 5, 10);

        # subtract 2x(5^x) per digit of the original number
        for ($i = 0, $iMax = strlen($snafu); $i < $iMax; $i++) {
            $temp = 2 * (5**$i);
            $dec -= $temp;
        }

        return $dec;
    }

    public static function fromDecimal(int $dec): string
    {
        $digits = [
            -2 => '=',
            -1 => '-',
             0 => '0',
             1 => '1',
             2 => '2',
        ];

        $snafu = [];
        $carry = false;
        while ($dec > 0) {
            $digit = $dec % 5 + (int)$carry;
            if ($carry = ($digit > 2)) {
                $digit -= 5;
            }
            $snafu[] = $digits[$digit];
            $dec = intdiv($dec, 5);
        }
        if ($carry) {
            $snafu[] = "1";
        }
        return implode('', array_reverse($snafu));
    }
}


echo "Part 1: sum snafu is ", Snafu::fromDecimal($sum);

echo "\ntotal time: ", (microtime(true) - $startTime), "\n";

