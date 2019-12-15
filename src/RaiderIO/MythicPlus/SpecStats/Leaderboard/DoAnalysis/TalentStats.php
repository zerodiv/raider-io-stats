<?php

namespace RaiderIO\MythicPlus\SpecStats\Leaderboard\DoAnalysis;

use RaiderIO\MythicPlus\SpecStats\Leaderboard\DoAnalysis\Talent;
use RaiderIO\CharacterClass;

class TalentStats
{
    private int $_characters = 0;
    private int $_badSpec = 0;
    private array $_talents = array();
    private array $_stats = array();

    public function getCharacterCount(): int
    {
        return $this->_characters;
    }

    public function getBadSpecCount(): int
    {
        return $this->_badSpec;
    }
    
    public function processTalentStack(string $class, string $spec, array $talentStack): bool
    {

        // check for validitity of the talent stack we are about to process.
        if (! is_array($talentStack) || count($talentStack) == 0) {
            $this->_badSpec++;
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
            $this->addTalentStats($class, $spec, $talent);
        }

        // a characters talents has been processed.
        $this->_characters++;

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

    public function addTalentStats(string $class, string $spec, Talent $talent): bool
    {
        $key = $talent->getKey();

        if (! array_key_exists($key, $this->_stats)) {
            $this->_stats[$key] = 0;
        }

        $this->_stats[$key]++;

        return true;
    }

    public function getTalentStats(string $class, string $spec): array
    {
        $talentGrid = array();

        $talents = CharacterClass::getTalentsForClassSpec($class, $spec);

        if (count($talents) == 0) {
            return $talentGrid;
        }

        foreach ($talents as $spellId) {
            $talentGrid[$spellId] = 0;
        }

        foreach ($this->_talents as $talent) {
            $key = $talent->getKey();
            
            if (!array_key_exists($key, $this->_stats)) {
                continue;
            }

            $spellId  = $talent->getSpellId();
            $talentGrid[$spellId] = $this->_stats[$key];
        }
        
        return $talentGrid;
    }
}
