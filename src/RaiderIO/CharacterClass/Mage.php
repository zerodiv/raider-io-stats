<?php

namespace RaiderIO\CharacterClass;

class Mage
{
    public static function get_mage_class_arcane_spec_mythicplus_spec(): string
    {
        return 'spec_0';
    }

    public static function get_mage_class_arcane_spec_talents(): array
    {
        return array(
        236628, 264354, 205022, // Amplification, Rule of Threes, Arcane Familiar
        235463, 212653, 236457, // Mana Shield, Shimmer, Slipstream
        1463, 55342, 116011, // Incanter's Flow, Mirror Image, Rune of Power
        205028, 205032, 157980, // Resonance, Charged Up, Supernova
        235711, 205036, 113724, // Chrono Shift, Ice Ward, Ring of Frost
        281482, 210725, 114923, // Reverberate, Touch of the Magi, Nether Tempest
        155147, 210805, 153626, // Overpowered, Time Anomaly, Arcane Orb
        );
    }

    public static function get_mage_class_arcane_spec_talent_names(): array
    {
        return array(
            236628 => "Amplification",
            264354 => "Rule of Threes",
            205022 => "Arcane Familiar",
            235463 => "Mana Shield",
            212653 => "Shimmer",
            236457 => "Slipstream",
            1463 => "Incanter's Flow",
            55342 => "Mirror Image",
            116011 => "Rune of Power",
            205028 => "Resonance",
            205032 => "Charged Up",
            157980 => "Supernova",
            235711 => "Chrono Shift",
            205036 => "Ice Ward",
            113724 => "Ring of Frost",
            281482 => "Reverberate",
            210725 => "Touch of the Magi",
            114923 => "Nether Tempest",
            155147 => "Overpowered",
            210805 => "Time Anomaly",
            153626 => "Arcane Orb",
        );
    }

    public static function get_mage_class_fire_spec_mythicplus_spec(): string
    {
        return 'spec_1';
    }
        
    public static function get_mage_class_fire_spec_talents(): array
    {
        return array(
            205026, 205020, 269644, // Firestarter, Pyromaniac, Searing Touch
            235365, 212653, 157981, // Blazing Soul, Shimmer, Blast Wave
            1463, 55342, 116011, // Incanter's Flow, Mirror Image, Rune of Power
            205029, 235870, 257541, // Flame On, Alexstrasza's Fury, Phoenix Flames
            236058, 205036, 113724, // Frenetic Speed, Ice Ward, Ring of Frost
            205037, 205023, 44457, // Flame Patch, Conflagration, Living Bomb
            155148, 269650, 153561, // Kindling, Pyroclasm, Meteor
        );
    }

    public static function get_mage_class_fire_spec_talent_names(): array
    {
        return array(
            205026 => "Firestarter",
            205020 => "Pyromaniac",
            269644 => "Searing Touch",
            235365 => "Blazing Soul",
            212653 => "Shimmer",
            157981 => "Blast Wave",
            1463 => "Incanter's Flow",
            55342 => "Mirror Image",
            116011 => "Rune of Power",
            205029 => "Flame On",
            235870 => "Alexstrasza's Fury",
            257541 => "Phoenix Flames",
            236058 => "Frenetic Speed",
            205036 => "Ice Ward",
            113724 => "Ring of Frost",
            205037 => "Flame Patch",
            205023 => "Conflagration",
            44457 => "Living Bomb",
            155148 => "Kindling",
            269650 => "Pyroclasm",
            153561 => "Meteor",
        );
    }

    public static function get_mage_class_frost_spec_mythicplus_spec(): string
    {
        return 'spec_2';
    }

    public static function get_mage_class_frost_spec_talents(): array
    {
        return array(
            205027, 205024, 157997, // Bone Chilling, Lonely Winter, Ice Nova
            235297, 212653, 108839, // Glacial Insulation, Shimmer, Ice Floes
            1463, 55342, 116011, // Incanter's Flow, Mirror Image, Rune of Power
            205030, 278309, 257537, // Frozen Touch, Chain Reaction, Ebonbolt
            235224, 205036, 113724, // Frigid Winds, Ice Ward, Ring of Frost
            270233, 56377, 153595, // Freezing Rain, Splitting Ice, Comet Storm
            155149, 205021, 199786, // Thermal Void, Ray of Frost, Glacial Spike
        );
    }

    public static function get_mage_class_frost_spec_talent_names(): array
    {
        return array(
            205027 => "Bone Chilling",
            205024 => "Lonely Winter",
            157997 => "Ice Nova",
            235297 => "Glacial Insulation",
            212653 => "Shimmer",
            108839 => "Ice Floes",
            1463 => "Incanter's Flow",
            55342 => "Mirror Image",
            116011 => "Rune of Power",
            205030 => "Frozen Touch",
            278309 => "Chain Reaction",
            257537 => "Ebonbolt",
            235224 => "Frigid Winds",
            205036 => "Ice Ward",
            113724 => "Ring of Frost",
            270233 => "Freezing Rain",
            56377 => "Splitting Ice",
            153595 => "Comet Storm",
            155149 => "Thermal Void",
            205021 => "Ray of Frost",
            199786 => "Glacial Spike",
        );
    }
}
