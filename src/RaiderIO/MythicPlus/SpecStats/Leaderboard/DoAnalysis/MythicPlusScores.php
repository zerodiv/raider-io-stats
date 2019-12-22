<?php

namespace RaiderIO\MythicPlus\SpecStats\Leaderboard\DoAnalysis;

use RaiderIO\CharacterClass;

class MythicPlusScores
{
    private int $_runnerCount;
    private array $_runnersByLevel;

    public function __construct()
    {
        $this->_runnerCount = 0;
        $this->_runnersByLevel = array();
    }
    
    public function getSpec0(): MythicPlusScoreSlice
    {
        return $this->_spec0;
    }
    
    public function getSpec1(): MythicPlusScoreSlice
    {
        return $this->_spec1;
    }

    public function getSpec2(): MythicPlusScoreSlice
    {
        return $this->_spec2;
    }

    public function getSpec3(): MythicPlusScoreSlice
    {
        return $this->_spec3;
    }

    public function getRunnerCount(): int
    {
        return $this->_runnerCount;
    }

    public function getRunnersByLevel(): array
    {
        return $this->_runnersByLevel;
    }

    public function getRunnersByLevelBucketed(): array
    {
        $runsByLevel = $this->getRunnersByLevel();
        
        $runsByLevelBucketed = array(
            '0-4' => 0,
            '5-9' => 0,
            '10-14' => 0,
            '15-19' => 0,
            '20-24' => 0,
            '25-29' => 0,
            '30-34' => 0
        );

        foreach ($runsByLevel as $level => $ranAmount) {
            if ($level <= 4) {
                $runsByLevelBucketed['0-4'] += $ranAmount;
            } elseif ($level <= 9) {
                $runsByLevelBucketed['5-9'] += $ranAmount;
            } elseif ($level <= 14) {
                $runsByLevelBucketed['10-14'] += $ranAmount;
            } elseif ($level <= 19) {
                $runsByLevelBucketed['15-19'] += $ranAmount;
            } elseif ($level <= 24) {
                $runsByLevelBucketed['20-24'] += $ranAmount;
            } elseif ($level <= 29) {
                $runsByLevelBucketed['25-29'] += $ranAmount;
            } elseif ($level <= 34) {
                $runsByLevelBucketed['30-34'] += $ranAmount;
            }
        }
        return $runsByLevelBucketed;
    }

    public function processMythicPlusStack(string $class, string $spec, array $mplusStack): int
    {
       
        // https://raider.io/api/characters/mythic-plus-runs?season=season-bfa-3&characterId=1285441
        // &role=all&mode=scored&affixes=all&date=all

        // top level nodes to care about
        $parseSpecTree = array(
            'spec_0' => new MythicPlusScoreSlice(),
            'spec_1' => new MythicPlusScoreSlice(),
            'spec_2' => new MythicPlusScoreSlice(),
            'spec_3' => new MythicPlusScoreSlice()
        );

        //      spec_0 | spec_1 | spec_2 | spec_4
        // dk : blood  | frost  | unholy | na
        // dru: bal    | feral  | guardian | resto
        foreach ($parseSpecTree as $specTree => $scoreSlice) {
            if (array_key_exists($specTree, $mplusStack) !== true) {
                continue;
            }

            $scoreSlice->parseChildTree($mplusStack[$specTree]);
        }

        
        $mplusSpec = CharacterClass::getMythicPlusSpec($class, $spec);

        if (! array_key_exists($mplusSpec, $parseSpecTree)) {
            return false;
        }

        $specObj = $parseSpecTree[$mplusSpec];

        $runs = $specObj->getRuns();

        // $runCount = count($runs);
        // if ($runCount > 100) {
        //     $objHash = spl_object_hash($specObj);
        //     echo "runCount - $runCount objHash=$objHash\n";
        // }
    
        $highestRun = -1;

        foreach ($runs as $run) {
            $mythicLevel = $run->getMythicLevel();
            if ($mythicLevel > $highestRun) {
                $highestRun = $mythicLevel;
            }
        }

        // this character failed to run any instances wthin this season.
        if ($highestRun == -1) {
            return 0;
        }
        
        if (! array_key_exists($highestRun, $this->_runnersByLevel)) {
            $this->_runnersByLevel[$highestRun] = 0;
        }

        $this->_runnersByLevel[$highestRun]++;
        $this->_runnerCount++;
            
        return $highestRun;
    }
}
