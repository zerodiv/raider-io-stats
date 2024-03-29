<?php

require_once './src/path.php';

use RaiderIO\MythicPlus\SpecStats\Leaderboard\Downloader;
use RaiderIO\MythicPlus\Seasons;
use RaiderIO\Regions;
use RaiderIO\CharacterClass;

// TODO: Support multiple classes and specs.
foreach (Seasons::getActiveSeasons() as $season) {
    foreach (Regions::getActiveRegions() as $region) {
        foreach (CharacterClass::getActiveClassesAndSpecs() as $class => $specs) {
            foreach ($specs as $spec) {
                doDownloader($season, $region, $class, $spec);
            }
        }
    }
}

function doDownloader(string $season, string $region, string $class, string $spec)
{
    $downloader = new Downloader($season, $region, $class, $spec);

    if ($downloader->download() === true) {
        echo "OK - Downloaded $season:$class:$spec\n";
    } else {
        echo "FAILED - Downloading $season:$class:$spec\n";
    }
}
