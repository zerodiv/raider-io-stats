<?php

namespace RaiderIO;

use RaiderIO\CharacterClass\DeathKnight;
use RaiderIO\CharacterClass\DemonHunter;
use RaiderIO\CharacterClass\Druid;
use RaiderIO\CharacterClass\Hunter;
use \ReflectionClass;

class CharacterClass
{
    private static bool $_builtLookupTables = false;

    // lookup tables for the overall system.
    private static array $_dyn_classNamesMap = array();
    private static array $_dyn_classesAndSpecsMap = array();
    private static array $_dyn_classSpecsTalentsMap = array();
    private static array $_dyn_classSpecsMap = array();
    private static array $_dyn_spellIdToNameMap = array();
    private static array $_dyn_classToMythicPlusSpecMap = array();

    public static function resolveTalentToName(int $spellId): string
    {
        if (array_key_exists($spellId, self::$_dyn_spellIdToNameMap)) {
            return self::$_dyn_spellIdToNameMap[$spellId];
        }
        return 'Unknown';
    }

    private static function buildLookupTables()
    {
        if (self::$_builtLookupTables === true) {
            return;
        }
       
        self::loadFunctionsFromClass(DeathKnight::class);
        self::loadFunctionsFromClass(DemonHunter::class);
        self::loadFunctionsFromClass(Druid::class);
        self::loadFunctionsFromClass(Hunter::class);

        self::$_builtLookupTables = true;
    }

    private static function loadFunctionsFromClass($sourceClass)
    {
        // --
        // snag a reflection of the target class, we need to run some of our child functions
        // to build the dynamic maps of the data we need.
        // --
        $reflection = new ReflectionClass($sourceClass);

        $methods = $reflection->getMethods();

        foreach ($methods as $method) {
            // ex: public static function get_death_knight_class_blood_spec_talents(): array
            $pregs = array();

            if (preg_match('/^get_(.*)_class_(.*)_spec_talents$/', $method->getName(), $pregs)) {
                $talentFunction = $pregs[0];
                $class = str_replace('_', '-', $pregs[1]);
                $spec  = $pregs[2];

                // add the class if it's new to us.
                self::$_dyn_classNamesMap[$class] = true;

                if (! array_key_exists($class, self::$_dyn_classesAndSpecsMap)) {
                    self::$_dyn_classesAndSpecsMap[$class] = array();
                }

                // since there is only 1 spec function per, we can blind add
                self::$_dyn_classesAndSpecsMap[$class][] = $spec;

                // build the key => resolve lookup map
                $classSpecKey = $class . '|' . $spec;
                
                // create the talent map for this combo.
                $talents = call_user_func($sourceClass . '::' . $talentFunction);

                // store away the talents jic you need it later.
                self::$_dyn_classSpecsMap[$classSpecKey] = $talents;

                foreach ($talents as $spellId) {
                    $spellKey = $class . '|' . $spec . '|' . $spellId;

                    self::$_dyn_classSpecsTalentsMap[$spellKey] = true;
                }
            }

            $pregs = array();

            if (preg_match('/^get_(.*)_spec_talent_names$/', $method->getName(), $pregs)) {
                $talentNamesFunction = $pregs[0];
                $talentNames = call_user_func($sourceClass . '::' . $talentNamesFunction);
            
                foreach ($talentNames as $spellId => $spellName) {
                    self::$_dyn_spellIdToNameMap[$spellId] = $spellName;
                }
            }
            
            if (preg_match('/^get_(.*)_class_(.*)_spec_mythicplus_spec$/', $method->getName(), $pregs)) {
                $mplusSpecFunction = $pregs[0];
                $class = str_replace('_', '-', $pregs[1]);
                $spec = $pregs[2];

                $mplusSpec = call_user_func($sourceClass . '::' . $mplusSpecFunction);

                $key = $class . '|' . $spec;

                self::$_dyn_classToMythicPlusSpecMap[$key] = $mplusSpec;
            }
        }
    }

    public static function getMythicPlusSpec(string $class, string $spec): ?string
    {
        $key = $class . '|' . $spec;
        if (array_key_exists($key, self::$_dyn_classToMythicPlusSpecMap)) {
            return self::$_dyn_classToMythicPlusSpecMap[$key];
        }
        return null;
    }

    public static function isSpellIdInTalentsForClass(string $class, string $spec, int $spellId): bool
    {
        self::buildLookupTables();
        
        $key = $class . '|' . $spec . '|' . $spellId;

        if (array_key_exists($key, self::$_dyn_classSpecsTalentsMap)) {
            return true;
        }

        echo "spell lookup failure spellId=$spellId\n";
        var_dump($key);
        var_dump(self::$_dyn_classSpecsTalentsMap);
        
        return false;
    }

    public static function getTalentsForClassSpec(string $class, string $spec): ?array
    {
        self::buildLookupTables();

        $classSpecKey = $class . '|' . $spec;

        if (array_key_exists($classSpecKey, self::$_dyn_classSpecsMap)) {
            return self::$_dyn_classSpecsMap[$classSpecKey];
        }

        return null;
    }

    public static function getActiveClassesAndSpecs()
    {
        self::buildLookupTables();
        
        return self::$_dyn_classesAndSpecsMap;
    }
    
    public static function isValidClass(string $class): bool
    {
        self::buildLookupTables();

        return array_key_exists($class, self::$_dyn_classNames);
    }

    

    public static function isValidClassSpecCombo(string $class, string $spec): bool
    {
        self::buildLookupTables();

        $classSpecKey = $class . '|' . $spec;

        
        if (array_key_exists($classSpecKey, self::$_dyn_classSpecsMap)) {
            return true;
        }

        return false;
    }




    public static function get_mage_class_arcane_spec_talents(): array
    {
        return array(
            236628, 264354, 205022, // amplification, rule of three, arcane familiar
            235463, 212653, 236457, // mana shield, shimmer, slipstream
            1463,   55342,  116011, // incater's flow, mirror image, runer of power
            205028, 205032, 157980, // resonance, charged up, supernova
            235711, 205036, 113724, // chrono shift, ice ward, ring of frost
            281482, 210725, 114923, // reverberate, touch of the magi, neter tempest
            155147, 210805, 153626, // overpowered, time anomaly, arcane orb
        );
    }
    
    public static function get_mage_class_fire_spec_talents(): array
    {
        return array(
            205026, 205020, 269644, // firestarter, pyromaniac, searing touch
            235365, 212653, 157981, // blazing soul, shimmer, blast wave
            1463,   55342,  116011, // incanter's flow, mirror image, rune of power
            205029, 235870, 257541, // flame on, alexstraza's fury
            236058, 205036, 113724, // frenetic speed, ice ward, ring of frost
            205037, 205023, 44457,  // flame patch, conflagration, living bomb
            155148, 269650, 153561, // kindling, pyroclasm, meteor
        );
    }

    // public static function get_mage_class_frost_spec_talents(): array
    // {
    //     return array(
    //         205027, 205024, 157997, // bone chilling, lonely winter, ice nova
    //         235297, 212653, 108839, // glacial insulation, shimmer, ice floes
    //         1463,   55342,  116011, // incanter's flow, mirror image, rune of power
    //         205030, 278309, 257537, // frozen touch, chain reaction, ebonbolt
    //         235224, 205036, 113724, // frigid winds, ice ward, ring of frost
    //         270233, 56377,  153595, // freezing rain, splitting ice, comet storm
    //         155149, 205021, 199786, // thermal void, ray of frost, glacial spike
    //     );
    // }

    // 'monk' => array(
    //     'brewmaster' => array(
    //         0, 0, 0, //
    //         0, 0, 0, //
    //         0, 0, 0, //
    //         0, 0, 0, //
    //         0, 0, 0, //
    //         0, 0, 0, //
    //         0, 0, 0 //
    //     ),
    //     'windwalker' => array(
    //         0, 0, 0, //
    //         0, 0, 0, //
    //         0, 0, 0, //
    //         0, 0, 0, //
    //         0, 0, 0, //
    //         0, 0, 0, //
    //         0, 0, 0 //
    //     ),
    //     'mistweaver' => array(
    //         0, 0, 0, //
    //         0, 0, 0, //
    //         0, 0, 0, //
    //         0, 0, 0, //
    //         0, 0, 0, //
    //         0, 0, 0, //
    //         0, 0, 0 //
    //     ),
    // ),
    // 'paladin' => array(
    //     'holy'          => array(
    //         0, 0, 0, //
    //         0, 0, 0, //
    //         0, 0, 0, //
    //         0, 0, 0, //
    //         0, 0, 0, //
    //         0, 0, 0, //
    //         0, 0, 0 //
    //     ),
    //     'protection'    => array(
    //         0, 0, 0, //
    //         0, 0, 0, //
    //         0, 0, 0, //
    //         0, 0, 0, //
    //         0, 0, 0, //
    //         0, 0, 0, //
    //         0, 0, 0 //
    //     ),
    //     'retribution'   => array(
    //         0, 0, 0, //
    //         0, 0, 0, //
    //         0, 0, 0, //
    //         0, 0, 0, //
    //         0, 0, 0, //
    //         0, 0, 0, //
    //         0, 0, 0 //
    //     ),
    // ),
    // 'priest' => array(
    //     'discipline'    => array(
    //         0, 0, 0, //
    //         0, 0, 0, //
    //         0, 0, 0, //
    //         0, 0, 0, //
    //         0, 0, 0, //
    //         0, 0, 0, //
    //         0, 0, 0 //
    //     ),
    //     'holy'          => array(
    //         0, 0, 0, //
    //         0, 0, 0, //
    //         0, 0, 0, //
    //         0, 0, 0, //
    //         0, 0, 0, //
    //         0, 0, 0, //
    //         0, 0, 0 //
    //     ),
    //     'shadow'        => array(
    //         0, 0, 0, //
    //         0, 0, 0, //
    //         0, 0, 0, //
    //         0, 0, 0, //
    //         0, 0, 0, //
    //         0, 0, 0, //
    //         0, 0, 0 //
    //     ),
    // ),
    // 'rogue' => array(
    //     'assassination' => array(
    //         0, 0, 0, //
    //         0, 0, 0, //
    //         0, 0, 0, //
    //         0, 0, 0, //
    //         0, 0, 0, //
    //         0, 0, 0, //
    //         0, 0, 0 //
    //     ),
    //     'outlaw' => array(
    //         0, 0, 0, //
    //         0, 0, 0, //
    //         0, 0, 0, //
    //         0, 0, 0, //
    //         0, 0, 0, //
    //         0, 0, 0, //
    //         0, 0, 0 //
    //     ),
    //     'subtlety' => array(
    //         0, 0, 0, //
    //         0, 0, 0, //
    //         0, 0, 0, //
    //         0, 0, 0, //
    //         0, 0, 0, //
    //         0, 0, 0, //
    //         0, 0, 0 //
    //     ),
    // ),
    // 'shaman' => array(
    //     'elemental' => array(
    //         0, 0, 0, //
    //         0, 0, 0, //
    //         0, 0, 0, //
    //         0, 0, 0, //
    //         0, 0, 0, //
    //         0, 0, 0, //
    //         0, 0, 0 //
    //     ),
    //     'enhancement' => array(
    //         0, 0, 0, //
    //         0, 0, 0, //
    //         0, 0, 0, //
    //         0, 0, 0, //
    //         0, 0, 0, //
    //         0, 0, 0, //
    //         0, 0, 0 //
    //     ),
    //     'restoration' => array(
    //         0, 0, 0, //
    //         0, 0, 0, //
    //         0, 0, 0, //
    //         0, 0, 0, //
    //         0, 0, 0, //
    //         0, 0, 0, //
    //         0, 0, 0 //
    //     ),
    // ),
    // 'warlock' => array(
    //     'affliction' => array(
    //         0, 0, 0, //
    //         0, 0, 0, //
    //         0, 0, 0, //
    //         0, 0, 0, //
    //         0, 0, 0, //
    //         0, 0, 0, //
    //         0, 0, 0 //
    //     ),
    //     'demonology' => array(
    //         0, 0, 0, //
    //         0, 0, 0, //
    //         0, 0, 0, //
    //         0, 0, 0, //
    //         0, 0, 0, //
    //         0, 0, 0, //
    //         0, 0, 0 //
    //     ),
    //     'destruction' => array(
    //         0, 0, 0, //
    //         0, 0, 0, //
    //         0, 0, 0, //
    //         0, 0, 0, //
    //         0, 0, 0, //
    //         0, 0, 0, //
    //         0, 0, 0 //
    //     ),
    // ),
    // 'warrior' => array(
    //     'arms' => array(
    //         0, 0, 0, //
    //         0, 0, 0, //
    //         0, 0, 0, //
    //         0, 0, 0, //
    //         0, 0, 0, //
    //         0, 0, 0, //
    //         0, 0, 0 //
    //     ),
    //     'fury' => array(
    //         0, 0, 0, //
    //         0, 0, 0, //
    //         0, 0, 0, //
    //         0, 0, 0, //
    //         0, 0, 0, //
    //         0, 0, 0, //
    //         0, 0, 0 //
    //     ),
    //     'protection' => array(
    //         0, 0, 0, //
    //         0, 0, 0, //
    //         0, 0, 0, //
    //         0, 0, 0, //
    //         0, 0, 0, //
    //         0, 0, 0, //
    //         0, 0, 0 //
    //     ),
    // )
}
