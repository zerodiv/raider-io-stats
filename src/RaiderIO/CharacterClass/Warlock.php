<?php

namespace RaiderIO\CharacterClass;

class Warlock
{
    // 'warlock' => array(
    //     'affliction'
    //     'demonology'
    //     'destruction'
    // ),
    public static function get_warlock_class_affliction_spec_mythicplus_spec(): string
    {
        return 'spec_0';
    }

    public static function get_warlock_class_affliction_spec_talents(): array
    {
        return array(
            108558, 198590, 264106, // Nightfall, Drain Soul, Deathbolt
            196102, 196103, 63106, // Writhe in Agony, Absolute Corruption, Siphon Life
            219272, 111400, 108416, // Demon Skin, Burning Rush, Dark Pact
            196226, 205179, 278350, // Sow the Seeds, Phantom Singularity, Vile Taint
            264874, 6789, 268358, // Darkfury, Mortal Coil, Demonic Circle
            32388, 48181, 108503, // Shadow Embrace, Haunt, Grimoire of Sacrifice
            215941, 264000, 113860, // Soul Conduit, Creeping Death, Dark Soul: Misery
        );
    }

    public static function get_warlock_class_affliction_spec_talent_names(): array
    {
        return array(
            108558 => "Nightfall",
            198590 => "Drain Soul",
            264106 => "Deathbolt",
            196102 => "Writhe in Agony",
            196103 => "Absolute Corruption",
            63106 => "Siphon Life",
            219272 => "Demon Skin",
            111400 => "Burning Rush",
            108416 => "Dark Pact",
            196226 => "Sow the Seeds",
            205179 => "Phantom Singularity",
            278350 => "Vile Taint",
            264874 => "Darkfury",
            6789 => "Mortal Coil",
            268358 => "Demonic Circle",
            32388 => "Shadow Embrace",
            48181 => "Haunt",
            108503 => "Grimoire of Sacrifice",
            215941 => "Soul Conduit",
            264000 => "Creeping Death",
            113860 => "Dark Soul: Misery",
        );
    }

    public static function get_warlock_class_demonology_spec_mythicplus_spec(): string
    {
        return 'spec_1';
    }

    public static function get_warlock_class_demonology_spec_talents(): array
    {
        return array(
            264078, 267171, 267211, // Dreadlash, Demonic Strength, Bilescourge Bombers
            205145, 264130, 265412, // Demonic Calling, Power Siphon, Doom
            219272, 111400, 108416, // Demon Skin, Burning Rush, Dark Pact
            267170, 264057, 264119, // From the Shadows, Soul Strike, Summon Vilefiend
            264874, 6789, 268358, // Darkfury, Mortal Coil, Demonic Circle
            215941, 267216, 111898, // Soul Conduit, Inner Demons, Grimoire: Felguard
            267214, 267215, 267217, // Sacrificed Souls, Demonic Consumption, Nether Portal
        );
    }

    public static function get_warlock_class_demonology_spec_talent_names(): array
    {
        return array(
            264078 => "Dreadlash",
            267171 => "Demonic Strength",
            267211 => "Bilescourge Bombers",
            205145 => "Demonic Calling",
            264130 => "Power Siphon",
            265412 => "Doom",
            219272 => "Demon Skin",
            111400 => "Burning Rush",
            108416 => "Dark Pact",
            267170 => "From the Shadows",
            264057 => "Soul Strike",
            264119 => "Summon Vilefiend",
            264874 => "Darkfury",
            6789 => "Mortal Coil",
            268358 => "Demonic Circle",
            215941 => "Soul Conduit",
            267216 => "Inner Demons",
            111898 => "Grimoire: Felguard",
            267214 => "Sacrificed Souls",
            267215 => "Demonic Consumption",
            267217 => "Nether Portal",
        );
    }

    public static function get_warlock_class_destruction_spec_mythicplus_spec(): string
    {
        return 'spec_2';
    }

    public static function get_warlock_class_destruction_spec_talents(): array
    {
        return array(
            267115, 196412, 6353, // Flashover, Eradication, Soul Fire
            205148, 266134, 17877, // Reverse Entropy, Internal Combustion, Shadowburn
            219272, 111400, 108416, // Demon Skin, Burning Rush, Dark Pact
            270545, 196408, 152108, // Inferno, Fire and Brimstone, Cataclysm
            264874, 6789, 268358, // Darkfury, Mortal Coil, Demonic Circle
            205184, 266086, 108503, // Roaring Blaze, Grimoire of Supremacy, Grimoire of Sacrifice
            215941, 196447, 113858, // Soul Conduit, Channel Demonfire, Dark Soul: Instability
        );
    }

    public static function get_warlock_class_destruction_spec_talent_names(): array
    {
        return array(
            267115 => "Flashover",
            196412 => "Eradication",
            6353 => "Soul Fire",
            205148 => "Reverse Entropy",
            266134 => "Internal Combustion",
            17877 => "Shadowburn",
            219272 => "Demon Skin",
            111400 => "Burning Rush",
            108416 => "Dark Pact",
            270545 => "Inferno",
            196408 => "Fire and Brimstone",
            152108 => "Cataclysm",
            264874 => "Darkfury",
            6789 => "Mortal Coil",
            268358 => "Demonic Circle",
            205184 => "Roaring Blaze",
            266086 => "Grimoire of Supremacy",
            108503 => "Grimoire of Sacrifice",
            215941 => "Soul Conduit",
            196447 => "Channel Demonfire",
            113858 => "Dark Soul: Instability",
        );
    }
}
