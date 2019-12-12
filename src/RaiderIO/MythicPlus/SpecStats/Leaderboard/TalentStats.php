<?php

namespace RaiderIO\MythicPlus\SpecStats\Leaderboard;

use RaiderIO\MythicPlus\SpecStats\Leaderboard\Talent;
use RaiderIO\CharacterClass;

class TalentStats
{
    private int $_characters = 0;
    private array $_talents = array();
    private array $_stats = array();

    public function getCharacterCount(): int
    {
        return $this->_characters;
    }

    public function processTalentStack(string $class, string $spec, array $talentStack): bool
    {

        // check for validitity of the talent stack we are about to process.
        if (! is_array($talentStack) || count($talentStack) != 7) {
            echo "  talentStack is invalid\n";
            var_dump($talentStack);
            var_dump(count($talentStack));
            return false;
        }

        $failCount = 0;
        $failed = array();

        foreach ($talentStack as $talentRaw) {
            $talent = new Talent();
            $talent->consumeRaw($talentRaw);

            // attempt to add the talent to our talent array.
            $this->addTalent($talent);

            // add the increment the stat usage
            if ($this->addTalentStats($class, $spec, $talent) !== true) {
                $failCount++;
                $failed[] = $talent;
            }
        }

        if ($failCount != 0) {
            $talents = CharacterClass::getTalentsForClassSpec($class, $spec);

            var_dump($class);
            var_dump($spec);
            echo "failed\n";
            var_dump($failed);
            var_dump($failCount);
            var_dump($talentStack);
            exit();
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
        $spellId = $talent->getSpellId();

        if (! CharacterClass::isSpellIdInTalentsForClass($class, $spec, $spellId)) {
            return false;
        }

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
