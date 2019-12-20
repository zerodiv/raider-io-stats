<?php

namespace RaiderIO;

use RaiderIO\CharacterClass\DeathKnight;
use RaiderIO\CharacterClass\DemonHunter;
use RaiderIO\CharacterClass\Druid;
use RaiderIO\CharacterClass\Hunter;
use RaiderIO\CharacterClass\Mage;
use RaiderIO\CharacterClass\Monk;
use RaiderIO\CharacterClass\Paladin;
use RaiderIO\CharacterClass\Priest;
use RaiderIO\CharacterClass\Rogue;
use RaiderIO\CharacterClass\Shaman;
use RaiderIO\CharacterClass\Warlock;
use RaiderIO\CharacterClass\Warrior;
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
        self::loadFunctionsFromClass(Mage::class);
        self::loadFunctionsFromClass(Monk::class);
        self::loadFunctionsFromClass(Paladin::class);
        self::loadFunctionsFromClass(Priest::class);
        self::loadFunctionsFromClass(Rogue::class);
        self::loadFunctionsFromClass(Shaman::class);
        self::loadFunctionsFromClass(Warlock::class);
        self::loadFunctionsFromClass(Warrior::class);
        
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
                $spec  = str_replace('_', '-', $pregs[2]);

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
                echo "loading=$talentFunction\n";
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
                echo "loading=$talentNamesFunction\n";
                $talentNames = call_user_func($sourceClass . '::' . $talentNamesFunction);
            
                foreach ($talentNames as $spellId => $spellName) {
                    self::$_dyn_spellIdToNameMap[$spellId] = $spellName;
                }
            }
            
            if (preg_match('/^get_(.*)_class_(.*)_spec_mythicplus_spec$/', $method->getName(), $pregs)) {
                $mplusSpecFunction = $pregs[0];
                echo "loading=$mplusSpecFunction\n";
                $class = str_replace('_', '-', $pregs[1]);
                $spec = str_replace('_', '-', $pregs[2]);

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
}
