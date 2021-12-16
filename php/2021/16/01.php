<?php

$startTime = microtime(true);

#$input = 'D2FE28';
$input = '38006F45291200';
#$input = 'EE00D40C823060';
#$input = '8A004A801A8002F478';
#$input = '620080001611562C8802118E34';
#$input = 'C0015000016115A2E0802F182340';
#$input = 'A0016C880162017C3686B18A3D4780';
#$input = 'E20D4100AA9C0199CA6A3D9D6352294D47B3AC6A4335FBE3FDD251003873657600B46F8DC600AE80273CCD2D5028B6600AF802B2959524B727D8A8CC3CCEEF3497188C017A005466DAA6FDB3A96D5944C014C006865D5A7255D79926F5E69200A164C1A65E26C867DDE7D7E4794FE72F3100C0159A42952A7008A6A5C189BCD456442E4A0A46008580273ADB3AD1224E600ACD37E802200084C1083F1540010E8D105A371802D3B845A0090E4BD59DE0E52FFC659A5EBE99AC2B7004A3ECC7E58814492C4E2918023379DA96006EC0008545B84B1B00010F8E915E1E20087D3D0E577B1C9A4C93DD233E2ECF65265D800031D97C8ACCCDDE74A64BD4CC284E401444B05F802B3711695C65BCC010A004067D2E7C4208A803F23B139B9470D7333B71240050A20042236C6A834600C4568F5048801098B90B626B00155271573008A4C7A71662848821001093CB4A009C77874200FCE6E7391049EB509FE3E910421924D3006C40198BB11E2A8803B1AE2A4431007A15C6E8F26009E002A725A5292D294FED5500C7170038C00E602A8CC00D60259D008B140201DC00C401B05400E201608804D45003C00393600B94400970020C00F6002127128C0129CDC7B4F46C91A0084E7C6648DC000DC89D341B23B8D95C802D09453A0069263D8219DF680E339003032A6F30F126780002CC333005E8035400042635C578A8200DC198890AA46F394B29C4016A4960C70017D99D7E8AF309CC014FCFDFB0FE0DA490A6F9D490010567A3780549539ED49167BA47338FAAC1F3005255AEC01200043A3E46C84E200CC4E895114C011C0054A522592912C9C8FDE10005D8164026C70066C200C4618BD074401E8C90E23ACDFE5642700A6672D73F285644B237E8CCCCB77738A0801A3CFED364B823334C46303496C940';

class Packet {

    private string $binary;
    /** @var Packet[] */
    private array $subpackets = [];
    private int $version;
    private int $type;
    private int $value;

    public function __construct(string &$binary)
    {
        $this->binary = $binary;
        $this->parse($binary);
    }

    private function parse(string &$binary): void
    {
        $this->version = bindec(self::cheapStreamRead($binary, 3));
        $this->type = bindec(self::cheapStreamRead($binary, 3));
        while (strlen($binary) > 8) {
            if ($this->type === 4) {
                $this->value = $this->decodeValue($binary);
                return;
            }

            $lengthType = self::cheapStreamRead($binary, 1);
            if ($lengthType === '0') {
                $totalLength = bindec(self::cheapStreamRead($binary, 15));
                $rawSubpackets = self::cheapStreamRead($binary, $totalLength);
                while (strlen($rawSubpackets) > 8) {
                    $this->subpackets[] = new Packet($rawSubpackets);
                }
                return;
            }
            if ($lengthType === '1') {
                $totalLength = bindec(substr($binary, 7, 11));
                return;
            }
        }
    }

    private function decodeValue(string &$binary): int {
        $rawVal = '';
        while (true) {
            $segment = self::cheapStreamRead($binary, 5);
            $rawVal .= substr($segment, 1, 4);
            if ($segment[0] === '0') {
                break;
            }
        }
        return bindec($rawVal);
    }

    public function getVersion(): int
    {
        return $this->version;
    }

    public function addVersionsRecursive(): int
    {
        $sum = $this->getVersion();
        foreach ($this->subpackets as $sub) {
            $sum += $sub->addVersionsRecursive();
        }
        return $sum;
    }

    private static function cheapStreamRead(string &$stream, int $length): string
    {
        if ($length < 1) {
            throw new InvalidArgumentException('cannot cut off less than 1 byte/bit');
        }

        $ret = substr($stream, 0, $length);
        $stream = substr($stream, $length);

        return $ret;
    }

    public static function hex2bin(string $hex): string
    {
        $binary = '';
        foreach (str_split($hex, 2) as $byte) {
            $binary .= str_pad(base_convert($byte, 16, 2), 8, "0", STR_PAD_LEFT);
        }
        return $binary;
    }
}

$binary = Packet::hex2bin($input);
$packet = new Packet($binary);


echo "\ntotal time: ", (microtime(true) - $startTime), "\n";

