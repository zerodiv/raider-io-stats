<?php

namespace RaiderIO;

use RaiderIO\CharacterClass\DeathKnight;
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

    // --
    // Spec functions, why are there two? Because on some php platforms array order isn't
    // guarenteed for hashes.
    // --

    public static function get_death_knight_class_frost_spec_talents(): array
    {
        return array(
            253593, 194878, 281208, // Inexorable Assault, Icy Talons, Cold Heart
            207104, 207061, 57330,  // Runic Attenuation, Murderous Efficiency, Horn of Winter
            276079, 108194, 207167, // Death's Reach, Asphyxiate, Blinding Sleet
            207142, 194909, 207230, // Avalanche, Frozen Pulse, Frostscythe
            207200, 212552, 48743,  // Permafrost, Wraith Walk, Death Pact
            194912, 194913, 279302, // Gathering Storm, Glacial Advance, Frostwyrm's Fury
            207126, 281238, 152279, // Icecap, Obliteration, Breath of Sindragosa
        );
    }

    public static function get_death_knight_class_unholy_spec_talents(): array
    {
        return array(
            207272, 194916, 207311, // Infected Claws, All Will Serve, Clawing Shadows
            207264, 207269, 115989, // Bursting Sores, Ebon Fever, Unholy Blight
            273952, 276079, 108194, // Grip of the Dead, Death's Reach, Asphyxiate
            194917, 276023, 130736, // Pestilent Pustules, Harbinger of Doom, Soul Reaper
            207321, 212552, 48743,  // Spell Eater, Wraith Walk, Death Pact
            277234, 152280, 207317, // Pestilence, Defile, Epidemic
            276837, 207289, 49206   // Army of the Damned, Unholy Frenzy, Summon Gargoyle
        );
    }

    public static function get_demon_hunter_class_havoc_spec_talents(): array
    {
        return array(
            203550, 206478, 232893, // Blind Fury, Demonic Appetite, Felblade
            258876, 203555, 258920, // Insatiable Hunger, Demon Blades, Immolation Aura
            258881, 192939, 258925, // Trail of Ruin, Fel Mastery, Fel Barrage
            204909, 205411, 196555, // Soul Rending, Desperate Instincts, Netherwalk
            258887, 206416, 258860, // Cycle of Hatred, First Blood, Dark Slash
            206477, 203556, 211881, // Unleashed Power, Master of the Glaive, Fel Eruption
            213410, 206476, 206491  // Demonic, Momentum, Nemesis
        );
    }

    public static function get_demon_hunter_class_vengeance_spec_talents(): array
    {
        return array(
            207550, 207548, 209400, // Abyssal Strike , Agonizing Flames, Razor Spikes
            207697, 227174, 207739, // Feast of Souls, Fallout, Burning Alive
            227322, 264002, 232893, // Flame Crash, Charred Flesh, Fellblade
            217996, 218612, 263642, // Soul Rending, Feed the Demon, Fracture
            207666, 209281, 202138, // Concentrated Sigils, Quickened Sigils, Sigil of Chains
            264004, 247454, 212084, // Gluttony, Spirit Bomb, Fel Devastation
            209258, 268175, 263648  // Last Resort, Void Reaver, Soul Barrier
        );
    }

    public static function get_druid_class_balance_spec_talents(): array
    {
        return  array(
            202430, 202425, 205636, // Nature's Balance, Warrior of Elune, Force of Nature
            252216, 108238, 102401, // Tiger Dash, Renewal, Wild Charge
            202157, 197491, 197492, // Feral Affinity, Guardian Affinity, Restoration Affinity
            5211,   102359, 132469, // Mighty Bash, Mass Entanglement, Typhoon
            114107, 202345, 102560, // Soul of the Forest, Starlord, Incarnation: Chosen of Elune
            202354, 279620, 202347, // Stellar Drift, Twin Moons, Stellar Flare
            202342, 202770, 274281  // Shooting Stars, Fury of Elune, New Moon
        );
    }

    public static function get_druid_class_feral_spec_talents(): array
    {
        return array(
            202021, 202031, 155580, // Predator, Sabertooth, Lunar Inspiration
            252216, 108238, 102401, // Tiger Dash, Renewal, Wild Charge
            197488, 217615, 197492, // Balance Affinity, Guardian Affinity, Restoration Affinity
            5211,   102359, 132469, // Mighty Bash, Mass Entanglement, Typhoon
            158476, 52610,  102543, // Soul of the Forest, Savage Roar, Incarnation: King of the Jungle
            285564, 202028, 285381, // Scent of Blood, Brutal Slash, Primal Wrath
            236068, 155672, 274837  // Moment of Clarity, Bloodtalons, Feral Frenzy
        );
    }

    public static function get_druid_class_guardian_spec_talents(): array
    {
        return array(
            203953, 203962, 155835, // Brambles, Blood Frenzy, Bristling Fur
            252216, 102793, 102401, // Tiger Dash, Ursol's Vortex, Wild Charge
            197488, 202155, 197492, // Balance Affinity, Feral Affinity, Restoration Affinity
            5211,   102359, 132469, // Mighty Bash, Mass Entanglement, Typhoon
            158477, 203964, 102558, // Soul of the Forest, Galactic Guardian, Incarnation: Guardian of Ursoc
            203974, 203965, 155578, // Earthwarden, Survival of the Fittest, Guardian of Elune
            204053, 204066, 80313   // Rend and Tear, Lunar Beam, Pulverize
        );
    }
        
    public static function get_druid_class_restoration_spec_talents(): array
    {
        return array(
            207383, 200383, 102351, // Abundance, Prosperity, Cenarion Ward
            252216, 108238, 102401, // Tiger Dash, Renewal, Wild Charge
            197632, 197490, 197491, // Balance Affinity, Feral Affinity, Guardian Affinity
            5211,   102359, 132469, // Mighty Bash, Mass Entanglement, Typhoon
            158478, 200390, 33891,  // Soul of the Forest, Cultivation, Incarnation: Tree of Life
            197073, 197061, 207385, // Inner Peace, Stonebark, Spring Blossoms
            274902, 155675, 197721  // Photosynthesis, Germination, Flourish
         );
    }
    
    // public static function get_hunter_class_beast_mastery_spec_talents(): array
    // {
    //     return array(
    //         0, 0, 0, //
    //         0, 0, 0, //
    //         0, 0, 0, //
    //         0, 0, 0, //
    //         0, 0, 0, //
    //         0, 0, 0, //
    //         0, 0, 0 //
    //     );
    // }

    // 'hunter' => array(

    //     'marksmanship' => array(
    //         0, 0, 0, //
    //         0, 0, 0, //
    //         0, 0, 0, //
    //         0, 0, 0, //
    //         0, 0, 0, //
    //         0, 0, 0, //
    //         0, 0, 0 //
    //     ),
    //     'survival' => array(
    //         0, 0, 0, //
    //         0, 0, 0, //
    //         0, 0, 0, //
    //         0, 0, 0, //
    //         0, 0, 0, //
    //         0, 0, 0, //
    //         0, 0, 0 //
    //     ),
    // // ),

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
