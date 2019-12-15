<?php

namespace RaiderIO\MythicPlus\SpecStats\Leaderboard\DoAnalysis;

class Talent
{
    private int $_specId = 0;
    private string $_icon = '';
    private int $_spellId = 0;
    private int $_classId = 0;
    private int $_tierId = 0;
    private int $_columnId = 0;

    public function getSpecId(): int
    {
        return $this->_specId;
    }
    
    public function getIcon(): string
    {
        return $this->_icon;
    }

    public function getSpellId(): int
    {
        return $this->_spellId;
    }

    public function getClassId(): int
    {
        return $this->_classId;
    }

    public function getTierId(): int
    {
        return $this->_tierId;
    }

    public function getColumnId(): int
    {
        return $this->_columnId;
    }
    
    public function consumeRaw(array $rawTalent): bool
    {
        if (
            !array_key_exists('specId', $rawTalent) ||
            !array_key_exists('icon', $rawTalent) ||
            !array_key_exists('spellId', $rawTalent) ||
            !array_key_exists('classId', $rawTalent) ||
            !array_key_exists('tierId', $rawTalent) ||
            !array_key_exists('columnId', $rawTalent)) {
            return false;
        }

        $this->_specId = intval($rawTalent['specId']);
        $this->_icon = strval($rawTalent['icon']);
        $this->_spellId = intval($rawTalent['spellId']);
        $this->_classId = intval($rawTalent['classId']);
        $this->_tierId = intval($rawTalent['tierId']);
        $this->_columnId = intval($rawTalent['columnId']);

        return true;
    }

    public function getKey(): string
    {
        return $this->_classId . '-' . $this->_specId . '-' . $this->_spellId;
    }
}
