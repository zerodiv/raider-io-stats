<?php

namespace RaiderIO\MythicPlus\SpecStats\Leaderboard\DoAnalysis;

use RaiderIO\MythicPlus\SpecStats\Leaderboard\DoAnalysis\Talent;
use RaiderIO\CharacterClass;

class TalentStats
{
    private array $_characters = array();
    private array $_badSpec = array();
    private array $_talents = array();
    private array $_stats = array();

    public function getPossibleCharacterCount(string $range): int
    {
        return $this->getCharacterCount($range) + $this->getBadSpecCount($range);
    }
    
    public function getAllCharacterCount(): int
    {
        $count = 0;
        foreach ($this->_characters as $range => $cnt) {
            $count += $cnt;
        }
        return $count;
    }

    public function getCharacterCount(string $range): int
    {
        if (array_key_exists($range, $this->_characters)) {
            return $this->_characters[$range];
        }
        return 0;
    }

    public function getBadSpecCount(string $range): int
    {
        if (array_key_exists($range, $this->_badSpec)) {
            return $this->_badSpec[$range];
        }
        return 0;
    }
    
    public function processTalentStack(string $class, string $spec, string $range, array $talentStack): bool
    {

        // check for validitity of the talent stack we are about to process.
        if (! is_array($talentStack) || count($talentStack) == 0) {
            if (! array_key_exists($range, $this->_badSpec)) {
                $this->_badSpec[$range] = 0;
            }
            $this->_badSpec[$range]++;
            return false;
        }

        $talents = array();
        foreach ($talentStack as $talentRaw) {
            $talent = new Talent();
            $talent->consumeRaw($talentRaw);

            $spellId = $talent->getSpellId();

            // bad or invalid talent found..
            if (! CharacterClass::isSpellIdInTalentsForClass($class, $spec, $spellId)) {
                return false;
            }
            
            $talents[] = $talent;
        }

        foreach ($talents as $talent) {
            
            // attempt to add the talent to our talent array.
            $this->addTalent($talent);

            // add the increment the stat usage
            $this->addTalentStats($class, $spec, $range, $talent);
        }

        // a characters talents has been processed.
        if (!array_key_exists($range, $this->_characters)) {
            $this->_characters[$range] = 0;
        }

        $this->_characters[$range]++;

        return true;
    }

    public function addTalent(Talent $talent): bool
    {
        $key = $talent->getKey();

        if (array_key_exists($key, $this->_talents)) {
            return false;
        }

        $this->_talents[$key] = $talent;

        return true;
    }

    public function addTalentStats(string $class, string $spec, string $range, Talent $talent): bool
    {
        $key = $talent->getKey();

        if (! array_key_exists($range, $this->_stats)) {
            $this->_stats[$range] = array();
        }

        if (! array_key_exists($key, $this->_stats[$range])) {
            $this->_stats[$range][$key] = 0;
        }

        $this->_stats[$range][$key]++;

        return true;
    }

    public function getTalentStats(string $class, string $spec, string $range): array
    {
        $talentGrid = array();

        $talents = CharacterClass::getTalentsForClassSpec($class, $spec);

        if (count($talents) == 0) {
            return $talentGrid;
        }

        foreach ($talents as $spellId) {
            $talentGrid[$spellId] = 0;
        }

        if (!array_key_exists($range, $this->_stats)) {
            //var_dump($this->_stats);
            return $talentGrid;
        }
        
        foreach ($this->_talents as $talent) {
            $key = $talent->getKey();
                        
            if (!array_key_exists($key, $this->_stats[$range])) {
                continue;
            }

            $spellId  = $talent->getSpellId();
            $talentGrid[$spellId] = $this->_stats[$range][$key];
        }
        
        return $talentGrid;
    }
}
