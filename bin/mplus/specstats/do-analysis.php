<?php

require_once './src/path.php';

use RaiderIO\MythicPlus\SpecStats\Leaderboard\DoAnalysis;
use RaiderIO\MythicPlus\Seasons;
use RaiderIO\Regions;
use RaiderIO\CharacterClass;

// TODO: Support multiple classes and specs.
foreach (Seasons::getActiveSeasons() as $season) {
    foreach (Regions::getActiveRegions() as $region) {
        foreach (CharacterClass::getActiveClassesAndSpecs() as $class => $specs) {
            foreach ($specs as $spec) {
                $ana = new DoAnalysis($season, $region, $class, $spec);
                $ana->crunchNumbers();
            }
        }
    }
}
