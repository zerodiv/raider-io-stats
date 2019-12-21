<?php

namespace RaiderIO\MythicPlus\SpecStats\Leaderboard\DoAnalysis;

use RaiderIO\Essence;
use RaiderIO\Essences;

class NeckTraitStats
{
    private array $_slot_primary;
    private array $_slot_secondary;
    private int $_slot_primary_count;
    private int $_slot_secondary_count;
    

    public function __construct()
    {
        $this->_slot_primary = array();
        $this->_slot_secondary = array();
        $this->_slot_primary_count = 0;
        $this->_slot_secondary_count = 0;
        

        // itemDetails.items.neck.heart_of_azeroth.essences[]
        // {"slot":0,"id":12,"rank":4,
        //    "power":{
        //       "id":48,
        //       "essence":{
        //          "id":12,"name":"The Crucible of Flame",
        //          "shortName":"The Crucible of Flame",
        //          "description":"A raging fire is a force of massive destruction, and the bringer of new life."
        //       },
        //       "tierId":4,
        //       "majorPowerSpell":{
        //         "id":299353,"school":0,"icon":"spell_azerite_essence_15",
        //              "name":"Concentrated Flame","rank":"Azerite Essence"},
        //        "minorPowerSpell":{
        //           "id":299350,"school":0,"icon":"inv_radientazeritematrix",
        //           "name":"Ancient Flame","rank":null}
        //       }
        // }
    }

    public function getPrimarySlot(): array
    {
        return $this->_slot_primary;
    }

    public function getPrimarySlotCount(): int
    {
        return $this->_slot_primary_count;
    }

    public function getSecondarySlot(): array
    {
        return $this->_slot_secondary;
    }

    public function getSecondarySlotCount(): int
    {
        return $this->_slot_secondary_count;
    }

    public function handle(array $neck)
    {
        if (!array_key_exists('heart_of_azeroth', $neck)) {
            return false;
        }

        $heart_of_azeroth = $neck['heart_of_azeroth'];

        if (!array_key_exists('essences', $heart_of_azeroth) || ! is_array($heart_of_azeroth['essences'])) {
            return false;
        }

        $essences = $heart_of_azeroth['essences'];

        foreach ($essences as $rawEssence) {
            if (! array_key_exists('slot', $rawEssence)) {
                continue;
            }

            $slot = intval($rawEssence['slot']);

            $slotVariable = '';
            $slotCountVariable = '';

            if ($slot == 0) {
                $slotVariable = '_slot_primary';
                $slotCountVariable = '_slot_primary_count';
            } else {
                $slotVariable = '_slot_secondary';
                $slotCountVariable = '_slot_secondary_count';
            }

            $essence = Essences::consumeRaw($rawEssence);

            if (! $essence instanceof Essence) {
                continue;
            }
            
            $id = $essence->getId();

            if (! array_key_exists($id, $this->{ $slotVariable })) {
                $this->{$slotVariable}[$id] = 0;
            }

            $this->{$slotVariable}[$id]++;
            $this->{$slotCountVariable}++;
        }

        // var_dump($this->_slot_primary);
        // var_dump($this->_slot_secondary);
        // exit();
    }
}
