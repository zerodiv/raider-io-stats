<?php

namespace RaiderIO\MythicPlus;

class Ranges
{
    private static array $_ranges = array(
        '0-4'   ,
        '5-9'   ,
        '10-14' ,
        '15-19' ,
        '20-24' ,
        '25-29' ,
        '30-34'
    );

    public static function getRanges(): array
    {
        return self::$_ranges;
    }

    public static function convertRangeToSafeName(string $range): string
    {
        return str_replace('-', '_', $range);
    }

    public static function getRangeForLevel(int $mplusLevel): string
    {
        foreach (self::$_ranges as $range) {
            list($low, $high) = explode('-', $range);
            
            $low = intval($low);
            $high = intval($high);

            // var_dump($low);
            // var_dump($high);

            if ($mplusLevel >= $low && $mplusLevel <= $high) {
                return $range;
            }
        }

        return 'unknown-range';
    }
}
