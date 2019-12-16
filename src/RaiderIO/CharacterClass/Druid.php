<?php

namespace RaiderIO\CharacterClass;

class Druid
{
    public static function get_druid_class_balance_spec_mythicplus_spec(): string
    {
        return 'spec_0';
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

    public static function get_balence_class_blood_spec_talent_names(): array
    {
        return array(
            202430 => "Nature's Balance",
            202425 => "Warrior of Elune",
            205636 => "Force of Nature",
            252216 => "Tiger Dash",
            108238 => "Renewal",
            102401 => "Wild Charge",
            202157 => "Feral Affinity",
            197491 => "Guardian Affinity",
            197492 => "Restoration Affinity",
            5211 => "Mighty Bash",
            102359 => "Mass Entanglement",
            132469 => "Typhoon",
            114107 => "Soul of the Forest",
            202345 => "Starlord",
            102560 => "Incarnation: Chosen of Elune",
            202354 => "Stellar Drift",
            279620 => "Twin Moons",
            202347 => "Stellar Flare",
            202342 => "Shooting Stars",
            202770 => "Fury of Elune",
            274281 => "New Moon"
        );
    }

    public static function get_druid_class_feral_spec_mythicplus_spec(): string
    {
        return 'spec_1';
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

    public static function get_druid_class_feral_spec_talent_names(): array
    {
        return array(
            202021 => "Predator",
            202031 => "Sabertooth",
            155580 => "Lunar Inspiration",
            252216 => "Tiger Dash",
            108238 => "Renewal",
            102401 => "Wild Charge",
            197488 => "Balance Affinity",
            217615 => "Guardian Affinity",
            197492 => "Restoration Affinity",
            5211 => "Mighty Bash",
            102359 => "Mass Entanglement",
            132469 => "Typhoon",
            158476 => "Soul of the Forest",
            52610 => "Savage Roar",
            102543 => "Incarnation: King of the Jungle",
            285564 => "Scent of Blood",
            202028 => "Brutal Slash",
            285381 => "Primal Wrath",
            236068 => "Moment of Clarity",
            155672 => "Bloodtalons",
            274837 => "Feral Frenzy"
        );
    }

    public static function get_druid_class_guardian_spec_mythicplus_spec(): string
    {
        return 'spec_2';
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

    public static function get_druid_class_guardian_spec_talent_names(): array
    {
        return array(
            203953 => "Brambles",
            203962 => "Blood Frenzy",
            155835 => "Bristling Fur",
            252216 => "Tiger Dash",
            102793 => "Ursol's Vortex",
            102401 => "Wild Charge",
            197488 => "Balance Affinity",
            202155 => "Feral Affinity",
            197492 => "Restoration Affinity",
            5211 => "Mighty Bash",
            102359 => "Mass Entanglement",
            132469 => "Typhoon",
            158477 => "Soul of the Forest",
            203964 => "Galactic Guardian",
            102558 => "Incarnation: Guardian of Ursoc",
            203974 => "Earthwarden",
            203965 => "Survival of the Fittest",
            155578 => "Guardian of Elune",
            204053 => "Rend and Tear",
            204066 => "Lunar Beam",
            80313 => "Pulverize"
        );
    }
    
    public static function get_druid_class_restoration_spec_mythicplus_spec(): string
    {
        return 'spec_3';
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

    public static function get_druid_class_restoration_spec_talent_names(): array
    {
        return array(
            207383 => "Abundance",
            200383 => "Prosperity",
            102351 => "Cenarion Ward",
            252216 => "Tiger Dash",
            108238 => "Renewal",
            102401 => "Wild Charge",
            197632 => "Balance Affinity",
            197490 => "Feral Affinity",
            197491 => "Guardian Affinity",
            5211 => "Mighty Bash",
            102359 => "Mass Entanglement",
            132469 => "Typhoon",
            158478 => "Soul of the Forest",
            200390 => "Cultivation",
            33891 => "Incarnation: Tree of Life",
            197073 => "Inner Peace",
            197061 => "Stonebark",
            207385 => "Spring Blossoms",
            274902 => "Photosynthesis",
            155675 => "Germination",
            197721 => "Flourish"
        );
    }
}
