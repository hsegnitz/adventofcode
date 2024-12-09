<?php

$start = microtime(true);

#$fileMap = str_split(file_get_contents('example.txt'));
#$fileMap = str_split(file_get_contents('example2.txt'));
$fileMap = str_split(file_get_contents('input.txt'));



class FileSystemReader {
    private int $blockNumInFileForward = 0;
    private int $fileIdForward = -1;
    private int $blockNumInFileBackward = 0;
    private int $fileIdBackward = 0;
    private int $posInMap = -1;

    public function __construct(private array $fileMap) {
        // add another element representing empty space after the input
        $this->fileMap[] = 42;
    }

    // int for block, null for space
    private function getBlockFromFront(): ?int
    {
        if (count($this->fileMap) < 1) {
            return null;
        }
        if ($this->blockNumInFileForward < 1) {
            $this->posInMap++;
            $this->blockNumInFileForward = array_shift($this->fileMap);
            if ($this->posInMap % 2 == 0) {
                // this is a file
                $this->fileIdForward++;
            }
        }
        $this->blockNumInFileForward--;
        return ($this->posInMap % 2 == 0) ? $this->fileIdForward : null;
    }

    function getBlockFromBack(): ?int
    {
        if ($this->blockNumInFileBackward < 1) {
            if (count($this->fileMap) < 2) {
                return null;
            }

            // just remove and ignore blanks
            array_pop($this->fileMap);
            $this->blockNumInFileBackward = array_pop($this->fileMap);
            $this->fileIdBackward = floor((count($this->fileMap) + $this->posInMap) / 2)+1;
        }
        $this->blockNumInFileBackward--;
        return $this->fileIdBackward;
    }

    public function getChecksum(): int
    {
        $pos = 0;
        $checksum = 0;
        while(true) {
            $block = $this->getBlockFromFront() ?? $this->getBlockFromBack();
            if ($block === null) {
                return $checksum;
            }

            $checksum += ($pos++ * $block);
        }
    }

}



$filesystemreader = new FilesystemReader($fileMap);



/*
$test = str_split('0099811188827773336446555566');

foreach ($test as $pos => $value) {
    $checksum += $pos * (int)$value;
}*/

echo $filesystemreader->getChecksum(), "\n";

echo microtime(true) - $start;
echo "\n";
