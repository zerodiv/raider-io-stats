<?php

namespace RaiderIO;

class CharacterClass
{
    private static $_classSpecs = array(
        'mage' => array(
            'arcane' => 62,
            'fire' => 63,
            'frost' => 64
        ),
        'warrior' => array(
            'arms' => true,
            'fury' => true,
            'protection' => true
        )
    );

    private static array $_classSpecsTalents = array(
        'mage' => array(
            'arcane' => array(
                236628, 264354, 205022, // amplification, rule of three, arcane familiar
                235463, 212653, 236457, // mana shield, shimmer, slipstream
                1463,   55342,  116011, // incater's flow, mirror image, runer of power
                205028, 205032, 157980, // resonance, charged up, supernova
                235711, 205036, 113724, // chrono shift, ice ward, ring of frost
                281482, 210725, 114923, // reverberate, touch of the magi, neter tempest
                155147, 210805, 153626, // overpowered, time anomaly, arcane orb
            ),
            'fire' => array(
                205026, 205020, 269644, // firestarter, pyromaniac, searing touch
                235365, 212653, 157981, // blazing soul, shimmer, blast wave
                1463,   55342,  116011, // incanter's flow, mirror image, rune of power
                205029, 235870, 257541, // flame on, alexstraza's fury
                236058, 205036, 113724, // frenetic speed, ice ward, ring of frost
                205037, 205023, 44457,  // flame patch, conflagration, living bomb
                155148, 269650, 153561, // kindling, pyroclasm, meteor
            ),
            'frost' => array(
                205027, 205024, 157997, // bone chilling, lonely winter, ice nova
                235297, 212653, 108839, // glacial insulation, shimmer, ice floes
                1463,   55342,  116011, // incanter's flow, mirror image, rune of power
                205030, 278309, 257537, // frozen touch, chain reaction, ebonbolt
                235224, 205036, 113724, // frigid winds, ice ward, ring of frost
                270233, 56377,  153595, // freezing rain, splitting ice, comet storm
                155149, 205021, 199786, // thermal void, ray of frost, glacial spike
            )
        )
    );

    
    private static bool $_builtLookupTables = false;

    // lookup tables for the overall system.
    private static $_classNames = array();
    private static $_activeClassesAndSpecs = array();
    private static array $_classSpecsTalentsMap = array();

    private static function buildLookupTables()
    {
        if (self::$_builtLookupTables === true) {
            return;
        }

        // build up the activeClassesAndSpecs array
        foreach (self::$_classSpecs as $class => $specMap) {
            self::$_classNames[ $class ] = true;

            $specs = array_keys($specMap);
            self::$_activeClassesAndSpecs[$class] = $specs;
        }

        foreach (self::$_classSpecsTalents as $class => $specs) {
            foreach ($specs as $spec => $spells) {
                foreach ($spells as $spellId) {
                    $spellKey = $class . '|' . $spec . '|' . $spellId;

                    self::$_classSpecsTalentsMap[$spellKey] = true;
                }
            }
        }

        self::$_builtLookupTables = true;
    }

    public static function isSpellIdInTalentsForClass(string $class, string $spec, int $spellId): bool
    {
        self::buildLookupTables();
        
        $key = $class . '|' . $spec . '|' . $spellId;


        if (array_key_exists($key, self::$_classSpecsTalentsMap)) {
            return true;
        }

        echo "spell lookup failure spellId=$spellId\n";
        var_dump($key);
        var_dump(self::$_classSpecsTalentsMap);
        
        return false;
    }

    public static function getTalentsForClassSpec(string $class, string $spec): array
    {
        $talents = array();

        if (! array_key_exists($class, self::$_classSpecsTalents)) {
            return $talents;
        }

        if (! array_key_exists($spec, self::$_classSpecsTalents[$class])) {
            return $talents;
        }

        // we want to ensure a memcopy
        foreach (self::$_classSpecsTalents[$class][$spec] as $spellId) {
            $talents[] = $spellId;
        }

        return $talents;
    }

    public static function isValidSpecId(string $class, string $spec, int $specId): bool
    {
        if (! array_key_exists($class, self::$_classSpecs)) {
            return false;
        }

        if (! array_key_exists($spec, self::$_classSpecs[$class])) {
            return false;
        }

        if (self::$_classSpecs[$class][$spec] === true) {
            return false;
        }
        
        if ($specId === self::$_classSpecs[$class][$spec]) {
            return true;
        }

        return false;
    }

    public static function getActiveClassesAndSpecs()
    {
        self::buildLookupTables();
        
        return self::$_activeClassesAndSpecs;
    }
    
    public static function isValidClass(string $class): bool
    {
        self::buildLookupTables();

        return array_key_exists($class, self::$_classNames);
    }

    public static function isValidClassSpecCombo(string $class, string $spec): bool
    {
        self::buildLookupTables();

        if (array_key_exists($class, self::$_classSpecs) != true) {
            return false;
        }

        return array_key_exists($spec, self::$_classSpecs[$class]);
    }
}
