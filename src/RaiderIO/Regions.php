<?php 

namespace RaiderIO;

class Regions {

    private static $_regions = array( 
        'us' => true
    );

    private static $_activeRegions = array(
        'us'
    );

    public static function getActiveRegions() {
        return self::$_activeRegions;
    }

    public static function isValidRegion(string $region): bool {
        return array_key_exists($region, self::$_regions);
    }
}