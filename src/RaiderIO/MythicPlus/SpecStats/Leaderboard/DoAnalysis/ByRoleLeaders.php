<?php

namespace RaiderIO\MythicPlus\SpecStats\Leaderboard\DoAnalysis;

class ByRoleLeaders
{
    private $_ranges = array(
        // imo: the early numbers don't matter, except at th beginning of a expac.
        //'0-4'   ,
        //'5-9'   ,
        '10-14' ,
        '15-19' ,
        '20-24' ,
        '25-29' ,
        //'30-34'
    );

    private $_keyRoles = array(
        'dps', 'healer', 'tank'
    );

    private $_roles = array(
        // current class / spec combos
        // dps
        'death_knight_class_frost_spec' => 'dps',
        'death_knight_class_unholy_spec' => 'dps',
        'demon_hunter_class_havoc_spec' => 'dps',
        'druid_class_balance_spec' => 'dps',
        'druid_class_feral_spec' => 'dps',
        'hunter_class_beast_mastery_spec' => 'dps',
        'hunter_class_marksmanship_spec' => 'dps',
        'hunter_class_survival_spec' => 'dps',
        'mage_class_arcane_spec' => 'dps',
        'mage_class_fire_spec' => 'dps',
        'mage_class_frost_spec' => 'dps',
        'monk_class_windwalker_spec' => 'dps',
        'paladin_class_retribution_spec' => 'dps',
        'priest_class_discipline_spec' => 'dps',
        'priest_class_shadow_spec' => 'dps',
        'rogue_class_assassination_spec' => 'dps',
        'rogue_class_outlaw_spec' => 'dps',
        'rogue_class_subtlety_spec' => 'dps',
        'shaman_class_elemental_spec' => 'dps',
        'shaman_class_enhancement_spec' => 'dps',
        'warlock_class_affliction_spec' => 'dps',
        'warlock_class_demonology_spec' => 'dps',
        'warlock_class_destruction_spec' => 'dps',
        'warrior_class_arms_spec' => 'dps',
        'warrior_class_fury_spec' => 'dps',
        // healers
        'druid_class_restoration_spec' => 'healer',
        'monk_class_mistweaver_spec' => 'healer',
        'paladin_class_holy_spec' => 'healer',
        'priest_class_holy_spec' => 'healer',
        'shaman_class_restoration_spec' => 'healer',
        // tank
        'death_knight_class_blood_spec' => 'tank',
        'demon_hunter_class_vengeance_spec' => 'tank',
        'druid_class_guardian_spec' => 'tank',
        'monk_class_brewmaster_spec' => 'tank',
        'paladin_class_protection_spec' => 'tank',
        'warrior_class_protection_spec' => 'tank',
        'warrior_class_protection_spec' => 'tank',
    );

    public function getRanges(): array
    {
        return $this->_ranges;
    }

    public function getKeyRoles(): array
    {
        return $this->_keyRoles;
    }
    
    public function getRoleForClassAndSpec($class, $spec): string
    {
        $specString = $this->getClassSpecString($class, $spec);

        if (array_key_exists($specString, $this->_roles)) {
            return $this->_roles[$specString];
        }

        // not found.
        return '';
    }

    public function getClassSpecString(string $class, string $spec): string
    {
        return
          str_replace('-', '_', $class) . '_class_' .
          str_replace('-', '_', $spec) . '_spec';
    }

    public function getRoleBucketedData($analysisStack): array
    {
        $roleBucketedData = array();

        foreach ($analysisStack as $ana) {
            $class = $ana->getClass();
            $spec = $ana->getSpec();

            $role = $this->getRoleForClassAndSpec($class, $spec);

            if ($role == '') {
                echo "getRoleBucketed !WARN! Did not find role for class=$class spec=$spec\n";
                continue;
            }

            $classSpecString = $this->getClassSpecString($class, $spec);

            $runsByLevelBucketed = $ana->getMythicPlusStats()->getRunsByLevelBucketed();

            foreach ($runsByLevelBucketed as $levelRange => $ranAmount) {
                if (! array_key_exists($role, $roleBucketedData)) {
                    $roleBucketedData[$role] = array();
                }
                if (! array_key_exists($levelRange, $roleBucketedData[$role])) {
                    $roleBucketedData[$role][$levelRange] = array();
                }
                $roleBucketedData[$role][$levelRange][$classSpecString] = $ranAmount;
            }
        }

        var_dump($roleBucketedData);

        return $roleBucketedData;
    }
}
