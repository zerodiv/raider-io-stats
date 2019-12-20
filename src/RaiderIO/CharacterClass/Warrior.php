<?php

namespace RaiderIO\CharacterClass;

class Warrior
{
    // 'warrior' => array(
    //     'arms'
    //     'fury'
    //     'protection'
    // )
    public static function get_warrior_class_arms_spec_mythicplus_spec(): string
    {
        return 'spec_0';
    }

    public static function get_warrior_class_arms_spec_talents(): array
    {
        return array(
            262231, 29725, 260643, // War Machine, Sudden Death, Skullsplitter
            103827, 202168, 107570, // Double Time, Impending Victory, Storm Bolt
            281001, 202316, 772, // Massacre, Fervor of Battle, Rend
            29838, 202163, 197690, // Second Wind, Bounding Stride, Defensive Stance
            268243, 262161, 845, // Collateral Damage, Warbreaker, Cleave
            248621, 107574, 262228, // In For The Kill, Avatar, Deadly Calm
            152278, 262150, 152277, // Anger Management, Dreadnaught, Ravager
        );
    }

    public static function get_warrior_class_arms_spec_talent_names(): array
    {
        return array(
            262231 => "War Machine",
            29725 => "Sudden Death",
            260643 => "Skullsplitter",
            103827 => "Double Time",
            202168 => "Impending Victory",
            107570 => "Storm Bolt",
            281001 => "Massacre",
            202316 => "Fervor of Battle",
            772 => "Rend",
            29838 => "Second Wind",
            202163 => "Bounding Stride",
            197690 => "Defensive Stance",
            268243 => "Collateral Damage",
            262161 => "Warbreaker",
            845 => "Cleave",
            248621 => "In For The Kill",
            107574 => "Avatar",
            262228 => "Deadly Calm",
            152278 => "Anger Management",
            262150 => "Dreadnaught",
            152277 => "Ravager",
        );
    }

    public static function get_warrior_class_fury_spec_mythicplus_spec(): string
    {
        return 'spec_1';
    }

    public static function get_warrior_class_fury_spec_talents(): array
    {
        return array(
            262231, 202296, 215568, // War Machine, Endless Rage, Fresh Meat
            103827, 202168, 107570, // Double Time, Impending Victory, Storm Bolt
            215573, 280721, 100130, // Inner Rage, Sudden Death, Furious Slash
            202224, 202163, 208154, // Furious Charge, Bounding Stride, Warpaint
            202922, 206315, 215571, // Carnage, Massacre, Frothing Berserker
            280392, 118000, 46924, // Meat Cleaver, Dragon Roar, Bladestorm
            202751, 152278, 280772, // Reckless Abandon, Anger Management, Siegebreaker
        );
    }

    public static function get_warrior_class_fury_spec_talent_names(): array
    {
        return array(
            262231 => "War Machine",
            202296 => "Endless Rage",
            215568 => "Fresh Meat",
            103827 => "Double Time",
            202168 => "Impending Victory",
            107570 => "Storm Bolt",
            215573 => "Inner Rage",
            280721 => "Sudden Death",
            100130 => "Furious Slash",
            202224 => "Furious Charge",
            202163 => "Bounding Stride",
            208154 => "Warpaint",
            202922 => "Carnage",
            206315 => "Massacre",
            215571 => "Frothing Berserker",
            280392 => "Meat Cleaver",
            118000 => "Dragon Roar",
            46924 => "Bladestorm",
            202751 => "Reckless Abandon",
            152278 => "Anger Management",
            280772 => "Siegebreaker",
        );
    }

    public static function get_warrior_class_protection_spec_mythicplus_spec(): string
    {
        return 'spec_2';
    }

    public static function get_warrior_class_protection_spec_talents(): array
    {
        return array(
            202603, 275334, 202168, // Into the Fray, Punish, Impending Victory
            203201, 202163, 223657, // Crackling Thunder, Bounding Stride, Safeguard
            202560, 275336, 118000, // Best Served Cold, Unstoppable Force, Dragon Roar
            202095, 202561, 280001, // Indomitable, Never Surrender, Bolster
            275338, 275339, 107570, // Menace, Rumbling Earth, Storm Bolt
            202743, 202572, 236279, // Booming Voice, Vengeance, Devastator
            152278, 203177, 228920, // Anger Management, Heavy Repercussions, Ravager
        );
    }

    public static function get_warrior_class_protection_spec_talent_names(): array
    {
        return array(
            202603 => "Into the Fray",
            275334 => "Punish",
            202168 => "Impending Victory",
            203201 => "Crackling Thunder",
            202163 => "Bounding Stride",
            223657 => "Safeguard",
            202560 => "Best Served Cold",
            275336 => "Unstoppable Force",
            118000 => "Dragon Roar",
            202095 => "Indomitable",
            202561 => "Never Surrender",
            280001 => "Bolster",
            275338 => "Menace",
            275339 => "Rumbling Earth",
            107570 => "Storm Bolt",
            202743 => "Booming Voice",
            202572 => "Vengeance",
            236279 => "Devastator",
            152278 => "Anger Management",
            203177 => "Heavy Repercussions",
            228920 => "Ravager",
        );
    }
}
