<?php

namespace RaiderIO\MythicPlus\SpecStats\Leaderboard\DoAnalysis;

use RaiderIO\CharacterClass;

class MythicPlusScores
{
    
    // calculated data
    private int $_runCount;
    private array $_runByLevel;

    public function __construct()
    {
        // calculated data
        $this->_calcCount = 0;
        $this->_runCount = 0;
        $this->_runByLevel = array();
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

    public function getCalcCount(): int
    {
        return $this->_calcCount;
    }

    public function getRunCount(): int
    {
        return $this->_runCount;
    }

    public function getRunsByLevel(): array
    {
        return $this->_runByLevel;
    }

    public function getRunsByLevelBucketed(): array
    {
        $runsByLevel = $this->getRunsByLevel();
        
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

    public function processMythicPlusStack(string $class, string $spec, array $mplusStack): bool
    {
        $this->_calcCount++;
       
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

        $runCount = count($runs);

        if ($runCount > 100) {
            $objHash = spl_object_hash($specObj);
            echo "runCount - $runCount objHash=$objHash\n";
        }
            
        foreach ($runs as $run) {
            $mythicLevel = $run->getMythicLevel();
            if (! array_key_exists($mythicLevel, $this->_runByLevel)) {
                $this->_runByLevel[$mythicLevel] = 0;
            }
            $this->_runByLevel[$mythicLevel]++;
            $this->_runCount++;
        }
        
        return true;
    }
}
