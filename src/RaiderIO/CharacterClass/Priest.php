<?php

namespace RaiderIO\CharacterClass;

class Priest
{
    public static function get_priest_class_discipline_spec_mythicplus_spec(): string
    {
        return 'spec_0';
    }

    public static function get_priest_class_discipline_spec_talents(): array
    {
        return array(
            193134, 265259, 214621, // Castigation, Twist of Fate, Schism
            64129, 193063, 121536, // Body and Soul, Masochism, Angelic Feather
            197045, 123040, 129250, // Shield Discipline, Mindbender, Power Word: Solace
            196704, 205367, 204263, // Psychic Voice, Dominant Mind, Shining Force
            280391, 197419, 204065, // Sins of the Many, Contrition, Shadow Covenant
            204197, 110744, 120517, // Purge the Wicked, Divine Star, Halo
            238063, 271466, 246287, // Lenience, Luminous Barrier, Evangelism
        );
    }

    public static function get_priest_class_discipline_spec_talent_names(): array
    {
        return array(
            193134 => "Castigation",
            265259 => "Twist of Fate",
            214621 => "Schism",
            64129 => "Body and Soul",
            193063 => "Masochism",
            121536 => "Angelic Feather",
            197045 => "Shield Discipline",
            123040 => "Mindbender",
            129250 => "Power Word: Solace",
            196704 => "Psychic Voice",
            205367 => "Dominant Mind",
            204263 => "Shining Force",
            280391 => "Sins of the Many",
            197419 => "Contrition",
            204065 => "Shadow Covenant",
            204197 => "Purge the Wicked",
            110744 => "Divine Star",
            120517 => "Halo",
            238063 => "Lenience",
            271466 => "Luminous Barrier",
            246287 => "Evangelism",
        );
    }

    public static function get_priest_class_holy_spec_mythicplus_spec(): string
    {
        return 'spec_1';
    }

    public static function get_priest_class_holy_spec_talents(): array
    {
        return array(
            193155, 200128, 200153, // Enlightenment, Trail of Light, Enduring Renewal
            238100, 235189, 121536, // Angel's Mercy, Perseverance, Angelic Feather
            238136, 200209, 196707, // Cosmic Ripple, Guardian Angel, Afterlife
            196704, 200199, 204263, // Psychic Voice, Censure, Shining Force
            109186, 32546, 204883, // Surge of Light, Binding Heal, Circle of Healing
            193157, 110744, 120517, // Benediction, Divine Star, Halo
            196985, 200183, 265202, // Light of the Naaru, Apotheosis, Holy Word: Salvation
        );
    }

    public static function get_priest_class_holy_spec_talent_names(): array
    {
        return array(
            193155 => "Enlightenment",
            200128 => "Trail of Light",
            200153 => "Enduring Renewal",
            238100 => "Angel's Mercy",
            235189 => "Perseverance",
            121536 => "Angelic Feather",
            238136 => "Cosmic Ripple",
            200209 => "Guardian Angel",
            196707 => "Afterlife",
            196704 => "Psychic Voice",
            200199 => "Censure",
            204263 => "Shining Force",
            109186 => "Surge of Light",
            32546 => "Binding Heal",
            204883 => "Circle of Healing",
            193157 => "Benediction",
            110744 => "Divine Star",
            120517 => "Halo",
            196985 => "Light of the Naaru",
            200183 => "Apotheosis",
            265202 => "Holy Word: Salvation",
        );
    }

    public static function get_priest_class_shadow_spec_mythicplus_spec(): string
    {
        return 'spec_2';
    }

    public static function get_priest_class_shadow_spec_talents(): array
    {
        return array(
            193195, 162452, 205351, // Fortress of the Mind, Shadowy Insight, Shadow Word: Void
            64129, 199855, 288733, // Body and Soul, San'layn, Intangibility
            109142, 238558, 263346, // Twist of Fate, Misery, Dark Void
            263716, 205369, 64044, // Last Word, Mind Bomb, Psychic Horror
            155271, 32379, 205385, // Auspicious Spirits, Shadow Word: Death, Shadow Crash
            199849, 200174, 263165, // Lingering Insanity, Mindbender, Void Torrent
            193225, 280711, 193223, // Legacy of the Void, Dark Ascension, Surrender to Madness
        );
    }

    public static function get_priest_class_shadow_spec_talent_names(): array
    {
        return array(
            193195 => "Fortress of the Mind",
            162452 => "Shadowy Insight",
            205351 => "Shadow Word: Void",
            64129 => "Body and Soul",
            199855 => "San'layn",
            288733 => "Intangibility",
            109142 => "Twist of Fate",
            238558 => "Misery",
            263346 => "Dark Void",
            263716 => "Last Word",
            205369 => "Mind Bomb",
            64044 => "Psychic Horror",
            155271 => "Auspicious Spirits",
            32379 => "Shadow Word: Death",
            205385 => "Shadow Crash",
            199849 => "Lingering Insanity",
            200174 => "Mindbender",
            263165 => "Void Torrent",
            193225 => "Legacy of the Void",
            280711 => "Dark Ascension",
            193223 => "Surrender to Madness",
        );
    }
}
