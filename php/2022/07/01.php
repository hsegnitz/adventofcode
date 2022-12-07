<?php

$startTime = microtime(true);

#$input = file('example.txt', FILE_IGNORE_NEW_LINES);
$input = file('in.txt', FILE_IGNORE_NEW_LINES);



abstract class FSItem {
    protected ?Dir $parent;
    public function __construct(protected string $name, protected int $size = 0) {
    }
    public function setParent(Dir $parent): self {
        $this->parent = $parent;
        return $this;
    }

    public function getName(): string {
        return $this->name;
    }

    public function getParent(): Dir {
        return $this->parent;
    }

    abstract public function getSize(): int;
}

class Dir extends FSItem {
    /** @var FSItem[] */
    private array $children = [];

    /** @var Dir[] */
    public static array $flatDirs = [];

    public function addChild(FSItem $child): self {
        $this->children[$child->getName()] = $child;
        $child->setParent($this);
        return $this;
    }

    public function getSize(): int
    {
        $size = $this->size;
        foreach ($this->children as $child) {
            $size += $child->getSize();
        }
        return $size;
    }

    /**
     * @return FSItem[]
     */
    public function getChildren(): array {
        return $this->children;
    }

    public static function getTree(array $commands): Dir {
        $root = new Dir('');
        $currentDir = $root;
        $currentPath = [''];
        self::$flatDirs = ['' => $root];
        array_shift($commands); # skip first - cd / is just fluff
        foreach ($commands as $command) {
            if ($command === '$ cd ..') {
                $currentDir = $currentDir->getParent();
                array_pop($currentPath);
                continue;
            }
            if ($command === '$ ls') {
                continue;
            }
            if (str_starts_with($command, '$ cd')) {
                [, , $dirName] = explode(' ', $command);
                if (isset($currentDir->getChildren()[$dirName])) {
                    $currentDir = $currentDir->getChildren()[$dirName];
                    $currentPath[] = $dirName;
                    continue;
                }
                throw new RuntimeException('tried to enter directory (' . $dirName . ') which is not initialized');
            }
            if (str_starts_with($command, 'dir')) {
                [, $dirName] = explode(' ', $command);
                if (isset($currentDir->getChildren()[$dirName])) {
                    continue;
                }
                $newDir = new Dir($dirName);
                $currentDir->addChild($newDir);
                self::$flatDirs[implode('/', $currentPath) . '/' . $dirName] = $newDir;
                continue;
            }
            [$size, $filename] = explode(' ', $command);
            if (is_numeric($size) && !empty($filename)) {
                $currentDir->addChild(new File($filename, $size));
                continue;
            }
            throw new RuntimeException('unparsed commend: ' . $command);
        }

        return $root;
    }
}

class File extends FSItem {
    public function getSize(): int {
        return $this->size;
    }
}

$root = Dir::getTree($input);

$smallDirs = [];
$allDirs = [];
foreach (Dir::$flatDirs as $path => $dir) {
    $sum = $dir->getSize();
    $allDirs[$path] = $sum;
    if ($sum <= 100_000) {
        $smallDirs[] = $sum;
    }
}

echo "Part 1: ", array_sum($smallDirs), "\n";

$total = 70000000;
$aimFree = 30000000;
$needed = $aimFree - ($total - $allDirs['']);

asort($allDirs);

foreach ($allDirs as $dir => $size) {
    if ($size >= $needed) {
        echo "Part 2: ", $size;
        break;
    }
}


echo "\ntotal time: ", (microtime(true) - $startTime), "\n";

