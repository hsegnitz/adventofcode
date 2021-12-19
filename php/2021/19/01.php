<?php

$startTime = microtime(true);

#$input = explode("\n\n", file_get_contents('./example0.txt'));
$input = explode("\n\n", file_get_contents('./example1.txt'));
#$input = explode("\n\n", file_get_contents('./in.txt'));


class Coord {

    public function __construct(public int $x, public int $y, public int $z)
    {}

    public function getVector(Coord $coord): Vector
    {
        return new Vector(
            $coord->x - $this->x,
            $coord->y - $this->y,
            $coord->z - $this->z,
        );
    }

    public function __toString(): string
    {
        return "{$this->x},{$this->y},{$this->z}";
    }

    public function add(Vector $v): Coord
    {
        return new static(
            $this->x + $v->x,
            $this->y + $v->y,
            $this->z + $v->z,
        );
    }
}

class Vector extends Coord {
}

class Transformer
{
    private array $functions = [];

    public function __construct()
    {
        $this->functions['XYZ'] = static function (Coord $coords):Coord { return $coords; };
        $this->functions['XYz'] = static function (Coord $coords):Coord { return new Coord($coords->x,    $coords->y,    $coords->z*-1); };
        $this->functions['XyZ'] = static function (Coord $coords):Coord { return new Coord($coords->x,    $coords->y*-1, $coords->z   ); };
        $this->functions['Xyz'] = static function (Coord $coords):Coord { return new Coord($coords->x,    $coords->y*-1, $coords->z*-1); };
        $this->functions['xYZ'] = static function (Coord $coords):Coord { return new Coord($coords->x*-1, $coords->y,    $coords->z   ); };
        $this->functions['xYz'] = static function (Coord $coords):Coord { return new Coord($coords->x*-1, $coords->y,    $coords->z*-1); };
        $this->functions['xyZ'] = static function (Coord $coords):Coord { return new Coord($coords->x*-1, $coords->y*-1, $coords->z   ); };
        $this->functions['xyz'] = static function (Coord $coords):Coord { return new Coord($coords->x*-1, $coords->y*-1, $coords->z*-1); };

        $this->functions['XZY'] = static function (Coord $coords):Coord { return new Coord($coords->x,    $coords->z,    $coords->y   ); };
        $this->functions['XZy'] = static function (Coord $coords):Coord { return new Coord($coords->x,    $coords->z,    $coords->y*-1); };
        $this->functions['XzY'] = static function (Coord $coords):Coord { return new Coord($coords->x,    $coords->z*-1, $coords->y   ); };
        $this->functions['Xzy'] = static function (Coord $coords):Coord { return new Coord($coords->x,    $coords->z*-1, $coords->y*-1); };
        $this->functions['xZY'] = static function (Coord $coords):Coord { return new Coord($coords->x*-1, $coords->z,    $coords->y   ); };
        $this->functions['xZy'] = static function (Coord $coords):Coord { return new Coord($coords->x*-1, $coords->z,    $coords->y*-1); };
        $this->functions['xzY'] = static function (Coord $coords):Coord { return new Coord($coords->x*-1, $coords->z*-1, $coords->y   ); };
        $this->functions['xzy'] = static function (Coord $coords):Coord { return new Coord($coords->x*-1, $coords->z*-1, $coords->y*-1); };

        $this->functions['YXZ'] = static function (Coord $coords):Coord { return new Coord($coords->y,    $coords->x,    $coords->z   ); };
        $this->functions['YXz'] = static function (Coord $coords):Coord { return new Coord($coords->y,    $coords->x,    $coords->z*-1); };
        $this->functions['YxZ'] = static function (Coord $coords):Coord { return new Coord($coords->y,    $coords->x*-1, $coords->z   ); };
        $this->functions['Yxz'] = static function (Coord $coords):Coord { return new Coord($coords->y,    $coords->x*-1, $coords->z*-1); };
        $this->functions['yXZ'] = static function (Coord $coords):Coord { return new Coord($coords->y*-1, $coords->x,    $coords->z   ); };
        $this->functions['yXz'] = static function (Coord $coords):Coord { return new Coord($coords->y*-1, $coords->x,    $coords->z*-1); };
        $this->functions['yxZ'] = static function (Coord $coords):Coord { return new Coord($coords->y*-1, $coords->x*-1, $coords->z   ); };
        $this->functions['yxz'] = static function (Coord $coords):Coord { return new Coord($coords->y*-1, $coords->x*-1, $coords->z*-1); };

        $this->functions['YZX'] = static function (Coord $coords):Coord { return new Coord($coords->y,    $coords->z,    $coords->x   ); };
        $this->functions['YZx'] = static function (Coord $coords):Coord { return new Coord($coords->y,    $coords->z,    $coords->x*-1); };
        $this->functions['YzX'] = static function (Coord $coords):Coord { return new Coord($coords->y,    $coords->z*-1, $coords->x   ); };
        $this->functions['Yzx'] = static function (Coord $coords):Coord { return new Coord($coords->y,    $coords->z*-1, $coords->x*-1); };
        $this->functions['yZX'] = static function (Coord $coords):Coord { return new Coord($coords->y*-1, $coords->z,    $coords->x   ); };
        $this->functions['yZx'] = static function (Coord $coords):Coord { return new Coord($coords->y*-1, $coords->z,    $coords->x*-1); };
        $this->functions['yzX'] = static function (Coord $coords):Coord { return new Coord($coords->y*-1, $coords->z*-1, $coords->x   ); };
        $this->functions['yzx'] = static function (Coord $coords):Coord { return new Coord($coords->y*-1, $coords->z*-1, $coords->x*-1); };

        $this->functions['ZYX'] = static function (Coord $coords):Coord { return new Coord($coords->z,    $coords->y,    $coords->x   ); };
        $this->functions['ZYx'] = static function (Coord $coords):Coord { return new Coord($coords->z,    $coords->y,    $coords->x*-1); };
        $this->functions['ZyX'] = static function (Coord $coords):Coord { return new Coord($coords->z,    $coords->y*-1, $coords->x   ); };
        $this->functions['Zyx'] = static function (Coord $coords):Coord { return new Coord($coords->z,    $coords->y*-1, $coords->x*-1); };
        $this->functions['zYX'] = static function (Coord $coords):Coord { return new Coord($coords->z*-1, $coords->y,    $coords->x   ); };
        $this->functions['zYx'] = static function (Coord $coords):Coord { return new Coord($coords->z*-1, $coords->y,    $coords->x*-1); };
        $this->functions['zyX'] = static function (Coord $coords):Coord { return new Coord($coords->z*-1, $coords->y*-1, $coords->x   ); };
        $this->functions['zyx'] = static function (Coord $coords):Coord { return new Coord($coords->z*-1, $coords->y*-1, $coords->x*-1); };

        $this->functions['ZXY'] = static function (Coord $coords):Coord { return new Coord($coords->z,    $coords->x,    $coords->y   ); };
        $this->functions['ZXy'] = static function (Coord $coords):Coord { return new Coord($coords->z,    $coords->x,    $coords->y*-1); };
        $this->functions['ZxY'] = static function (Coord $coords):Coord { return new Coord($coords->z,    $coords->x*-1, $coords->y   ); };
        $this->functions['Zxy'] = static function (Coord $coords):Coord { return new Coord($coords->z,    $coords->x*-1, $coords->y*-1); };
        $this->functions['zXY'] = static function (Coord $coords):Coord { return new Coord($coords->z*-1, $coords->x,    $coords->y   ); };
        $this->functions['zXy'] = static function (Coord $coords):Coord { return new Coord($coords->z*-1, $coords->x,    $coords->y*-1); };
        $this->functions['zxY'] = static function (Coord $coords):Coord { return new Coord($coords->z*-1, $coords->x*-1, $coords->y   ); };
        $this->functions['zxy'] = static function (Coord $coords):Coord { return new Coord($coords->z*-1, $coords->x*-1, $coords->y*-1); };
    }

    public function getFunctions(): array
    {
        return $this->functions;
    }
}

class Scanner
{
    private int $id;
    /** @var Coord[] */
    private array $beacons = [];

    /** @var Coord[][] */
    private array $beaconsPerRotFlip = [];

    /** @var Vector[][] */
    private array $vectorsPerRotFlip = [];
    private string $chosenTransformer = 'XYZ';
    private Vector $offset;
    public static Transformer $transformer;

    public function __construct(string $input)
    {
        $this->offset = new Vector(0, 0, 0);
        $split = explode("\n", $input);
        $first = array_shift($split);
        if (!preg_match('/--- scanner (\d+) ---/', $first, $out)) {
            throw new RuntimeException('fuck!');
        }
        $this->id = (int)$out[1];

        foreach ($split as $line) {
            $bs = explode(',', $line);
            $this->beacons[] = new Coord((int)$bs[0], (int)$bs[1], (int)$bs[2]);
        }

        foreach (self::$transformer->getFunctions() as $name => $function) {
            $this->beaconsPerRotFlip[$name] = [];
            foreach ($this->beacons as $num => $beacon) {
                $this->beaconsPerRotFlip[$name][$num] = $function($beacon);
            }
        }

        foreach ($this->beaconsPerRotFlip as $name => $beacons) {
            $this->vectorsPerRotFlip[$name] = [];
            foreach ($beacons as $idA => $beaconA) {
                foreach ($beacons as $idB => $beaconB) {
                    if ($idA === $idB) {
                        continue;
                    }
                    $this->vectorsPerRotFlip[$name]["{$idA},{$idB}"] = $beaconA->getVector($beaconB);
                }
            }
        }
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setChosenTransformer(string $transformer): void
    {
        $this->chosenTransformer = $transformer;
    }

    public function setOffset(Vector $offset): void
    {
        $this->offset = $offset;
    }

    public function getVectorsForTransformer(string $transformer): array
    {
        return $this->vectorsPerRotFlip[$transformer];
    }

    public function getVectors(): array
    {
        return $this->getVectorsForTransformer($this->chosenTransformer);
    }

    public function getChosenTransformer(): string
    {
        return $this->chosenTransformer;
    }

    /**
     * @return Coord[]
     */
    public function getCoordinatesWithOffset(): array
    {
        $ret = [];
        foreach ($this->beaconsPerRotFlip[$this->chosenTransformer] as $beacon) {
            $ret[] = $beacon->add($this->offset);
        }
        return $ret;
    }

    /**
     * @return Coord[]
     */
    public function getBeacons(): array
    {
        return $this->beaconsPerRotFlip[$this->chosenTransformer];
    }

    public function getOffset(): Vector
    {
        return $this->offset;
    }

    public function computeOffsetVector(Scanner $other): void
    {
        $commonVectors = array_intersect($this->getVectors(), $other->getVectors());

        $localVectorMap = [];
        foreach ($this->getVectors() as $key => $val) {
            $localVectorMap[(string)$val] = $key;
        }
        $otherVectorMap = [];
        foreach ($other->getVectors() as $key => $val) {
            $otherVectorMap[(string)$val] = $key;
        }

        $localCoords = $this->getBeacons();
        $otherCoords = $other->getBeacons();

        $offsetMatchCounts = [];
        foreach ($commonVectors as $cv) {
            $localPoints = explode(",", $localVectorMap[(string)$cv]);
            $otherPoints = explode(",", $otherVectorMap[(string)$cv]);
            $offset = (string)$localCoords[$localPoints[0]]->getVector($otherCoords[$otherPoints[0]]);
            if (!isset($offsetMatchCounts[$offset])) {
                $offsetMatchCounts[$offset] = 0;
            }
            ++$offsetMatchCounts[$offset];
            $offset = (string)$localCoords[$localPoints[1]]->getVector($otherCoords[$otherPoints[1]]);
            if (!isset($offsetMatchCounts[$offset])) {
                $offsetMatchCounts[$offset] = 0;
            }
            ++$offsetMatchCounts[$offset];
        }

        arsort($offsetMatchCounts);

        $this->setOffset(new Vector(...explode(",", key($offsetMatchCounts))));
    }
}

Scanner::$transformer = new Transformer();
$transformations = array_keys(Scanner::$transformer->getFunctions());

$scanners = [];
foreach ($input as $block) {
    $scanner = new Scanner(trim($block));
    $scanners[$scanner->getId()] = $scanner;
}


// let's find best candidates and lock their alignment

$currentScanner = $scanners[0];
unset($scanners[0]);
$lockedScanners = [$currentScanner->getId() => $currentScanner];
while (count($scanners) > 0) {
    $bestMatchesPerScanner = [];
    $bestTransformationPerScanner = [];
    $currentVectors = $currentScanner->getVectors();
    foreach ($scanners as $num => $scanner) {
        echo ",";
        $bestMatchesPerTransformation = [];
        foreach ($transformations as $transformation) {
            echo ".";
            $testVectors = $scanner->getVectorsForTransformer($transformation);
            $bestMatchesPerTransformation[count(array_intersect($currentVectors, $testVectors))] = $transformation;
        }
        $max = max(array_keys($bestMatchesPerTransformation));
        $bestMatchesPerScanner[$max] = $num;
        $bestTransformationPerScanner[$num] = $bestMatchesPerTransformation[$max];
    }

    echo $bestMatchMax = max(array_keys($bestMatchesPerScanner));
    $bestScannerNum = $bestMatchesPerScanner[$bestMatchMax];
    $bestScanner = $scanners[$bestScannerNum];
    unset($scanners[$bestScannerNum]);

    $bestScanner->setChosenTransformer($bestTransformationPerScanner[$bestScannerNum]);
    $bestScanner->computeOffsetVector($currentScanner);

    $lockedScanners[$bestScanner->getId()] = $bestScanner;
    $currentScanner = $bestScanner;

    echo "\n";
}

echo "Original Fliptation and Offsets\n";
foreach ($lockedScanners as $id => $scanner) {
    echo "{$id}: ", $scanner->getChosenTransformer(), ' ', $scanner->getOffset(), "\n";
}

$beacons = [];
$slidingOffset = new Vector(0, 0, 0);
foreach ($lockedScanners as $id => $scanner) {
    $slidingOffset = $slidingOffset->add($scanner->getOffset());
    $scanner->setOffset($slidingOffset);
    foreach ($scanner->getCoordinatesWithOffset() as $coord) {
        $beacons[(string)$coord] = $coord;
    }
}

echo count($beacons);


echo "\ntotal time: ", (microtime(true) - $startTime), "\n";

