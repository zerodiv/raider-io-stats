<?php

namespace RaiderIO\CharacterClass;

class Rogue
{
   
    // 'rogue' => array(
    //     'assassination'
    //     'outlaw'
    //     'subtlety'
    // ),
    public static function get_rogue_class_assassination_spec_mythicplus_spec(): string
    {
        return 'spec_0';
    }

    public static function get_rogue_class_assassination_spec_talents(): array
    {
        return array(
            196864, 193640, 111240, // Master Poisoner, Elaborate Planning, Blindside
            14062, 108208, 255989, // Nightstalker, Subterfuge, Master Assassin
            14983, 193531, 137619, // Vigor, Deeper Stratagem, Marked for Death
            280716, 31230, 79008, // Leeching Poison, Cheat Death, Elusiveness
            154904, 196861, 131511, // Internal Bleeding, Iron Wire, Prey on the Weak
            152152, 245388, 200806, // Venom Rush, Toxic Blade, Exsanguinate
            255544, 270061, 121411, // Poison Bomb, Hidden Blades, Crimson Tempest
        );
    }

    public static function get_rogue_class_assassination_spec_talent_names(): array
    {
        return array(
            196864 => "Master Poisoner",
            193640 => "Elaborate Planning",
            111240 => "Blindside",
            14062 => "Nightstalker",
            108208 => "Subterfuge",
            255989 => "Master Assassin",
            14983 => "Vigor",
            193531 => "Deeper Stratagem",
            137619 => "Marked for Death",
            280716 => "Leeching Poison",
            31230 => "Cheat Death",
            79008 => "Elusiveness",
            154904 => "Internal Bleeding",
            196861 => "Iron Wire",
            131511 => "Prey on the Weak",
            152152 => "Venom Rush",
            245388 => "Toxic Blade",
            200806 => "Exsanguinate",
            255544 => "Poison Bomb",
            270061 => "Hidden Blades",
            121411 => "Crimson Tempest",
        );
    }

    public static function get_rogue_class_outlaw_spec_mythicplus_spec(): string
    {
        return 'spec_1';
    }

    public static function get_rogue_class_outlaw_spec_talents(): array
    {
        return array(
            200733, 196938, 196937, // Weaponmaster, Quick Draw, Ghostly Strike
            196924, 256188, 196922, // Acrobatic Strikes, Retractable Hook, Hit and Run
            14983, 193531, 137619, // Vigor, Deeper Stratagem, Marked for Death
            193546, 31230, 79008, // Iron Stomach, Cheat Death, Elusiveness
            108216, 256165, 131511, // Dirty Tricks, Blinding Powder, Prey on the Weak
            256170, 193539, 5171, // Loaded Dice, Alacrity, Slice and Dice
            272026, 271877, 51690, // Dancing Steel, Blade Rush, Killing Spree
        );
    }

    public static function get_rogue_class_outlaw_spec_talent_names(): array
    {
        return array(
            200733 => "Weaponmaster",
            196938 => "Quick Draw",
            196937 => "Ghostly Strike",
            196924 => "Acrobatic Strikes",
            256188 => "Retractable Hook",
            196922 => "Hit and Run",
            14983 => "Vigor",
            193531 => "Deeper Stratagem",
            137619 => "Marked for Death",
            193546 => "Iron Stomach",
            31230 => "Cheat Death",
            79008 => "Elusiveness",
            108216 => "Dirty Tricks",
            256165 => "Blinding Powder",
            131511 => "Prey on the Weak",
            256170 => "Loaded Dice",
            193539 => "Alacrity",
            5171 => "Slice and Dice",
            272026 => "Dancing Steel",
            271877 => "Blade Rush",
            51690 => "Killing Spree",
        );
    }

    public static function get_rogue_class_subtlety_spec_mythicplus_spec(): string
    {
        return 'spec_2';
    }

    public static function get_rogue_class_subtlety_spec_talents(): array
    {
        return array(
            193537, 91023, 200758, // Weaponmaster, Find Weakness, Gloomblade
            14062, 108208, 108209, // Nightstalker, Subterfuge, Shadow Focus
            14983, 193531, 137619, // Vigor, Deeper Stratagem, Marked for Death
            200759, 31230, 79008, // Soothing Darkness, Cheat Death, Elusiveness
            257505, 277953, 131511, // Shot in the Dark, Night Terrors, Prey on the Weak
            245687, 193539, 238104, // Dark Shadow, Alacrity, Enveloping Shadows
            196976, 280719, 277925, // Master of Shadows, Secret Technique, Shuriken Tornado
        );
    }

    public static function get_rogue_class_subtlety_spec_talent_names(): array
    {
        return array(
            193537 => "Weaponmaster",
            91023 => "Find Weakness",
            200758 => "Gloomblade",
            14062 => "Nightstalker",
            108208 => "Subterfuge",
            108209 => "Shadow Focus",
            14983 => "Vigor",
            193531 => "Deeper Stratagem",
            137619 => "Marked for Death",
            200759 => "Soothing Darkness",
            31230 => "Cheat Death",
            79008 => "Elusiveness",
            257505 => "Shot in the Dark",
            277953 => "Night Terrors",
            131511 => "Prey on the Weak",
            245687 => "Dark Shadow",
            193539 => "Alacrity",
            238104 => "Enveloping Shadows",
            196976 => "Master of Shadows",
            280719 => "Secret Technique",
            277925 => "Shuriken Tornado",
        );
    }
}
