<?php

namespace RaiderIO\CharacterClass;

class Shaman
{

    // 'shaman' => array(
    //     'elemental'
    //     'enhancement'
    //     'restoration'
    // ),
    public static function get_shaman_class_elemental_spec_mythicplus_spec(): string
    {
        return 'spec_0';
    }

    public static function get_shaman_class_elemental_spec_talents(): array
    {
        return array(
            170374, 108283, 117014, // Earthen Rage, Echo of the Elements, Elemental Blast
            273221, 260897, 210643, // Aftershock, Call the Thunder, Totem Mastery
            260878, 974, 265046, // Spirit Wolf, Earth Shield, Static Charge
            16166, 192249, 192222, // Master of the Elements, Storm Elemental, Liquid Magma Totem
            30884, 108281, 192077, // Nature's Guardian, Ancestral Guidance, Wind Rush Totem
            262303, 117013, 210714, // Surge of Power, Primal Elementalist, Icefury
            260895, 191634, 114050, // Unlimited Power, Stormkeeper, Ascendance
        );
    }

    public static function get_shaman_class_elemental_spec_talent_names(): array
    {
        return array(
            170374 => "Earthen Rage",
            108283 => "Echo of the Elements",
            117014 => "Elemental Blast",
            273221 => "Aftershock",
            260897 => "Call the Thunder",
            210643 => "Totem Mastery",
            260878 => "Spirit Wolf",
            974 => "Earth Shield",
            265046 => "Static Charge",
            16166 => "Master of the Elements",
            192249 => "Storm Elemental",
            192222 => "Liquid Magma Totem",
            30884 => "Nature's Guardian",
            108281 => "Ancestral Guidance",
            192077 => "Wind Rush Totem",
            262303 => "Surge of Power",
            117013 => "Primal Elementalist",
            210714 => "Icefury",
            260895 => "Unlimited Power",
            191634 => "Stormkeeper",
            114050 => "Ascendance",
        );
    }

    public static function get_shaman_class_enhancement_spec_mythicplus_spec(): string
    {
        return 'spec_1';
    }

    public static function get_shaman_class_enhancement_spec_talents(): array
    {
        return array(
            246035, 201900, 192106, // Boulderfist, Hot Hand, Lightning Shield
            197992, 262647, 262395, // Landslide, Forceful Winds, Totem Mastery
            260878, 974, 265046, // Spirit Wolf, Earth Shield, Static Charge
            192087, 210853, 210727, // Searing Assault, Hailstorm, Overcharge
            30884, 196884, 192077, // Nature's Guardian, Feral Lunge, Wind Rush Totem
            192246, 197211, 197214, // Crashing Storm, Fury of Air, Sundering
            262624, 188089, 114051, // Elemental Spirits, Earthen Spike, Ascendance
        );
    }

    public static function get_shaman_class_enhancement_spec_talent_names(): array
    {
        return array(
            246035 => "Boulderfist",
            201900 => "Hot Hand",
            192106 => "Lightning Shield",
            197992 => "Landslide",
            262647 => "Forceful Winds",
            262395 => "Totem Mastery",
            260878 => "Spirit Wolf",
            974 => "Earth Shield",
            265046 => "Static Charge",
            192087 => "Searing Assault",
            210853 => "Hailstorm",
            210727 => "Overcharge",
            30884 => "Nature's Guardian",
            196884 => "Feral Lunge",
            192077 => "Wind Rush Totem",
            192246 => "Crashing Storm",
            197211 => "Fury of Air",
            197214 => "Sundering",
            262624 => "Elemental Spirits",
            188089 => "Earthen Spike",
            114051 => "Ascendance",
        );
    }

    public static function get_shaman_class_restoration_spec_mythicplus_spec(): string
    {
        return 'spec_2';
    }

    public static function get_shaman_class_restoration_spec_talents(): array
    {
        return array(
            200072, 200071, 73685, // Torrent, Undulation, Unleash Life
            108283, 200076, 974, // Echo of the Elements, Deluge, Earth Shield
            260878, 51485, 265046, // Spirit Wolf, Earthgrab Totem, Static Charge
            207401, 198838, 207399, // Ancestral Vigor, Earthen Wall Totem, Ancestral Protection Totem
            30884, 192088, 192077, // Nature's Guardian, Graceful Spirit, Wind Rush Totem
            280614, 207778, 157153, // Flash Flood, Downpour, Cloudburst Totem
            157154, 197995, 114052, // High Tide, Wellspring, Ascendance
        );
    }

    public static function get_shaman_class_restoration_spec_talent_names(): array
    {
        return array(
            200072 => "Torrent",
            200071 => "Undulation",
            73685 => "Unleash Life",
            108283 => "Echo of the Elements",
            200076 => "Deluge",
            974 => "Earth Shield",
            260878 => "Spirit Wolf",
            51485 => "Earthgrab Totem",
            265046 => "Static Charge",
            207401 => "Ancestral Vigor",
            198838 => "Earthen Wall Totem",
            207399 => "Ancestral Protection Totem",
            30884 => "Nature's Guardian",
            192088 => "Graceful Spirit",
            192077 => "Wind Rush Totem",
            280614 => "Flash Flood",
            207778 => "Downpour",
            157153 => "Cloudburst Totem",
            157154 => "High Tide",
            197995 => "Wellspring",
            114052 => "Ascendance",
        );
    }
}
