<?php

namespace RaiderIO\CharacterClass;

class Paladin
{
    public static function get_paladin_class_holy_spec_mythicplus_spec(): string
    {
        return 'spec_0';
    }

    public static function get_paladin_class_holy_spec_talents(): array
    {
        return array(
            196926, 223306, 114158, // Crusader's Might, Bestow Faith, Light's Hammer
            114154, 230332, 214202, // Unbreakable Spirit, Cavalier, Rule of Law
            198054, 20066, 115750, // Fist of Justice, Repentance, Blinding Light
            183425, 183416, 183415, // Devotion Aura, Aura of Sacrifice, Aura of Mercy
            183778, 114165, 105809, // Judgment of Light, Holy Prism, Holy Avenger
            53376, 216331, 248033, // Sanctified Wrath, Avenging Crusader, Awakening
            197646, 156910, 200025, // Divine Purpose, Beacon of Faith, Beacon of Virtue
        );
    }

    public static function get_paladin_class_holy_spec_talent_names(): array
    {
        return array(
            196926 => "Crusader's Might",
            223306 => "Bestow Faith",
            114158 => "Light's Hammer",
            114154 => "Unbreakable Spirit",
            230332 => "Cavalier",
            214202 => "Rule of Law",
            198054 => "Fist of Justice",
            20066 => "Repentance",
            115750 => "Blinding Light",
            183425 => "Devotion Aura",
            183416 => "Aura of Sacrifice",
            183415 => "Aura of Mercy",
            183778 => "Judgment of Light",
            114165 => "Holy Prism",
            105809 => "Holy Avenger",
            53376 => "Sanctified Wrath",
            216331 => "Avenging Crusader",
            248033 => "Awakening",
            197646 => "Divine Purpose",
            156910 => "Beacon of Faith",
            200025 => "Beacon of Virtue",
        );
    }

    public static function get_paladin_class_protection_spec_mythicplus_spec(): string
    {
        return 'spec_1';
    }

    public static function get_paladin_class_protection_spec_talents(): array
    {
        return array(
            152261, 280373, 204019, // Holy Shield, Redoubt, Blessed Hammer
            203776, 204023, 204035, // First Avenger, Crusader's Judgment, Bastion of Light
            198054, 20066, 115750, // Fist of Justice, Repentance, Blinding Light
            203797, 230332, 204018, // Retribution Aura, Cavalier, Blessing of Spellwarding
            114154, 204077, 213652, // Unbreakable Spirit, Final Stand, Hand of the Protector
            183778, 204054, 204150, // Judgment of Light, Consecrated Ground, Aegis of Light
            203791, 204074, 152262, // Last Defender, Righteous Protector, Seraphim
        );
    }

    public static function get_paladin_class_protection_spec_talent_names(): array
    {
        return array(
            152261 => "Holy Shield",
            280373 => "Redoubt",
            204019 => "Blessed Hammer",
            203776 => "First Avenger",
            204023 => "Crusader's Judgment",
            204035 => "Bastion of Light",
            198054 => "Fist of Justice",
            20066 => "Repentance",
            115750 => "Blinding Light",
            203797 => "Retribution Aura",
            230332 => "Cavalier",
            204018 => "Blessing of Spellwarding",
            114154 => "Unbreakable Spirit",
            204077 => "Final Stand",
            213652 => "Hand of the Protector",
            183778 => "Judgment of Light",
            204054 => "Consecrated Ground",
            204150 => "Aegis of Light",
            203791 => "Last Defender",
            204074 => "Righteous Protector",
            152262 => "Seraphim",
        );
    }

    public static function get_paladin_class_retribution_spec_mythicplus_spec(): string
    {
        return 'spec_2';
    }

    public static function get_paladin_class_retribution_spec_talents(): array
    {
        return array(
            269569, 267610, 267798, // Zeal, Righteous Verdict, Execution Sentence
            203316, 231832, 24275, // Fires of Justice, Blade of Wrath, Hammer of Wrath
            234299, 20066, 115750, // Fist of Justice, Repentance, Blinding Light
            271580, 205228, 255937, // Divine Judgment, Consecration, Wake of Ashes
            114154, 230332, 205191, // Unbreakable Spirit, Cavalier, Eye for an Eye
            85804, 215661, 210191, // Selfless Healer, Justicar's Vengeance, Word of Glory
            223817, 231895, 84963, // Divine Purpose, Crusade, Inquisition
        );
    }

    public static function get_paladin_class_retribution_spec_talent_names(): array
    {
        return array(
            269569 => "Zeal",
            267610 => "Righteous Verdict",
            267798 => "Execution Sentence",
            203316 => "Fires of Justice",
            231832 => "Blade of Wrath",
            24275 => "Hammer of Wrath",
            234299 => "Fist of Justice",
            20066 => "Repentance",
            115750 => "Blinding Light",
            271580 => "Divine Judgment",
            205228 => "Consecration",
            255937 => "Wake of Ashes",
            114154 => "Unbreakable Spirit",
            230332 => "Cavalier",
            205191 => "Eye for an Eye",
            85804 => "Selfless Healer",
            215661 => "Justicar's Vengeance",
            210191 => "Word of Glory",
            223817 => "Divine Purpose",
            231895 => "Crusade",
            84963 => "Inquisition",
        );
    }
}
