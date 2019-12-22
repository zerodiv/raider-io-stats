<?php

namespace RaiderIO\MythicPlus\SpecStats\Leaderboard\DoAnalysis;

use RaiderIO\Essence;
use RaiderIO\Essences;

class ItemStats
{
    const TRIM_TO_TOP = 5;
    
    private array $_items;
    private int $_count;
    
    // raider.io has bad data on it, sometimes non-duel wield classes get offhands.
    private $_dualWield = array(
        'death_knight_class_blood_spec' => false,
        'death_knight_class_frost_spec' => true,
        'death_knight_class_unholy_spec' => false,
        'demon_hunter_class_havoc_spec' => true,
        'demon_hunter_class_vengeance_spec' => true,
        'druid_class_balance_spec' => true,
        'druid_class_feral_spec' => true,
        'druid_class_guardian_spec' => false,
        'druid_class_restoration_spec' => false,
        'hunter_class_beast_mastery_spec' => false,
        'hunter_class_marksmanship_spec' => false,
        'hunter_class_survival_spec' => true,
        'mage_class_arcane_spec' => true,
        'mage_class_fire_spec' => true,
        'mage_class_frost_spec' => true,
        'monk_class_brewmaster_spec' => true,
        'monk_class_mistweaver_spec' => true,
        'monk_class_windwalker_spec' => true,
        'paladin_class_holy_spec' => true,
        'paladin_class_retribution_spec' => false,
        'paladin_class_protection_spec' => true,
        'priest_class_discipline_spec' => true,
        'priest_class_holy_spec' => true,
        'priest_class_shadow_spec' => true,
        'rogue_class_assassination_spec' => true,
        'rogue_class_outlaw_spec' => true,
        'rogue_class_subtlety_spec' => true,
        'shaman_class_elemental_spec' => true,
        'shaman_class_enhancement_spec' => true,
        'shaman_class_restoration_spec' => true,
        'warlock_class_affliction_spec' => true,
        'warlock_class_demonology_spec' => true,
        'warlock_class_destruction_spec' => true,
        'warrior_class_arms_spec' => false,
        'warrior_class_fury_spec' => true,
        'warrior_class_protection_spec' => true,
    );

    public function __construct()
    {
        // slot => itemIds => count
        $this->_items = array();
        $this->_count = 0;
        
        // <a href="#" data-wowhead="item=2828">hai</a>
    }

    public function getItems(): array
    {
        return $this->_items;
    }

    public function getCount(): int
    {
        return $this->_count;
    }
    
    public function dataQuality(string $contentFile, string $class, string $spec, array $items): bool
    {

        // all characters need a mainhand
        if (! array_key_exists('mainhand', $items)) {
            return false;
        }
        
        // --
        // Check to see if this spec an support dual wield if not,
        //   and the items list is dual wielding, most likely broken
        //   item listing.
        // --
        $canDualWield = true;
        
        $key = sprintf(
            '%s_class_%s_spec',
            str_replace('-', '_', $class),
            str_replace('-', '_', $spec),
        );
         
        if (array_key_exists($key, $this->_dualWield)) {
            $canDualWield - $this->_dualWield[$key];
        }

        if ($canDualWield === false) {

            // no offhand
            if (! array_key_exists('offhand', $items)) {
                return true;
            }
            
            $mainhand = $items['mainhand'];
            $offhand = $items['offhand'];

            if (
                array_key_exists('item_id', $mainhand) && intval($mainhand['item_id']) > 0 &&
                array_key_exists('item_id', $offhand) && intval($offhand['item_id']) > 0) {
                echo "dataQuality contentFile=$contentFile, has offhand when it shouldn't skipping\n";
                return false;
            }
        }
        
        return true;
    }
    public function handle(string $contentFile, string $class, string $spec, array $items)
    {
        $this->_count++;

        if ($this->dataQuality($contentFile, $class, $spec, $items) !== true) {
            return false;
        }

        foreach ($items as $slot => $item) {
            if ($slot == 'finger1' || $slot == 'finger2') {
                $slot = 'finger';
            }
            if ($slot == 'trinket1' || $slot == 'trinket2') {
                $slot = 'trinket';
            }
            if (! array_key_exists($slot, $this->_items)) {
                $this->_items[$slot] = array();
            }
            
            if (! array_key_exists('item_id', $item)) {
                continue;
            }
            
            $itemId = intval($item['item_id']);

            if (!array_key_exists($itemId, $this->_items[$slot])) {
                $this->_items[$slot][$itemId] = 0;
            }
                        
            $this->_items[$slot][$itemId]++;
        }

        //var_dump($this->_items);
        // exit();
    }

    public function trimToTop(): bool
    {
        foreach ($this->_items as $slot => $itemStats) {

            // stack sort the itemStats
            arsort($itemStats, SORT_NUMERIC);

            $trimmedList = array();

            $t = 0;
            foreach ($itemStats as $itemId => $useCount) {
                if ($t > self::TRIM_TO_TOP) {
                    continue;
                }
                $trimmedList[$itemId] = $useCount;
                $t++;
            }

            $this->_items[$slot] = $trimmedList;
        }

        return true;
    }
}
