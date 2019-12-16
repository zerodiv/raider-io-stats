<?php

require_once './src/path.php';

use RaiderIO\MythicPlus\SpecStats\Leaderboard\DoAnalysis;
use RaiderIO\MythicPlus\SpecStats\Leaderboard\DoAnalysis\HtmlWriter;
use RaiderIO\MythicPlus\SpecStats\Leaderboard\DoAnalysis\TextWriter;
use RaiderIO\MythicPlus\Seasons;
use RaiderIO\Regions;
use RaiderIO\CharacterClass;

// stand up a html writer and write the basic index page.
$html = new HtmlWriter();
$text = new TextWriter();

$doAmount = 0;
$doAmount = 9;

$didAmount = 0;
foreach (Seasons::getActiveSeasons() as $season) {
    foreach (Regions::getActiveRegions() as $region) {
        foreach (CharacterClass::getActiveClassesAndSpecs() as $class => $specs) {
            foreach ($specs as $spec) {
                // if we only want to process n number of analysis.
                if ($doAmount !== 0 && $didAmount >= $doAmount) {
                    continue;
                }
                $ana = new DoAnalysis($season, $region, $class, $spec);
                $ana->crunchNumbers();

                $text->writeAnalysis($ana);
                $html->addAnalysis($ana);
             
                $didAmount++;
            }
        }
    }
}

$html->writeIndex();

echo "DONE!\n";
