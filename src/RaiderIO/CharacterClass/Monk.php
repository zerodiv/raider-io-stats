<?php

namespace RaiderIO\CharacterClass;

class Monk
{
    public static function get_monk_class_brewmaster_spec_mythicplus_spec(): string
    {
        return 'spec_0';
    }

    public static function get_monk_class_brewmaster_spec_talents(): array
    {
        return array(
            196607, 115098, 123986, // Eye of the Tiger, Chi Wave, Chi Burst
            115173, 115008, 116841, // Celerity, Chi Torpedo, Tiger's Lust
            196721, 242580, 115399, // Light Brewing, Spitfire, Black Ox Brew
            264348, 115315, 116844, // Tiger Tail Sweep, Summon Black Ox Statue, Ring of Peace
            280515, 122281, 122278, // Bob and Weave, Healing Elixir, Dampen Harm
            196730, 116847, 132578, // Special Delivery, Rushing Jade Wind, Invoke Niuzao, the Black Ox
            196737, 115295, 196736, // High Tolerance, Guard, Blackout Combo
        );
    }

    public static function get_monk_class_brewmaster_spec_talent_names(): array
    {
        return array(
            196607 => "Eye of the Tiger",
            115098 => "Chi Wave",
            123986 => "Chi Burst",
            115173 => "Celerity",
            115008 => "Chi Torpedo",
            116841 => "Tiger's Lust",
            196721 => "Light Brewing",
            242580 => "Spitfire",
            115399 => "Black Ox Brew",
            264348 => "Tiger Tail Sweep",
            115315 => "Summon Black Ox Statue",
            116844 => "Ring of Peace",
            280515 => "Bob and Weave",
            122281 => "Healing Elixir",
            122278 => "Dampen Harm",
            196730 => "Special Delivery",
            116847 => "Rushing Jade Wind",
            132578 => "Invoke Niuzao, the Black Ox",
            196737 => "High Tolerance",
            115295 => "Guard",
            196736 => "Blackout Combo",
        );
    }

    public static function get_monk_class_mistweaver_spec_mythicplus_spec(): string
    {
        return 'spec_1';
    }

    public static function get_monk_class_mistweaver_spec_talents(): array
    {
        return array(
            197900, 115098, 123986, // Mist Wrap, Chi Wave, Chi Burst
            115173, 115008, 116841, // Celerity, Chi Torpedo, Tiger's Lust
            197915, 210802, 197908, // Lifecycles, Spirit of the Crane, Mana Tea
            264348, 198898, 116844, // Tiger Tail Sweep, Song of Chi-Ji, Ring of Peace
            122281, 122783, 122278, // Healing Elixir, Diffuse Magic, Dampen Harm
            115313, 196725, 198664, // Summon Jade Serpent Statue, Refreshing Jade Wind, Invoke Chi-Ji, the Red Crane
            197895, 274963, 274909, // Focused Thunder, Upwelling, Rising Mist
        );
    }

    public static function get_monk_class_mistweaver_spec_talent_names(): array
    {
        return array(
            197900 => "Mist Wrap",
            115098 => "Chi Wave",
            123986 => "Chi Burst",
            115173 => "Celerity",
            115008 => "Chi Torpedo",
            116841 => "Tiger's Lust",
            197915 => "Lifecycles",
            210802 => "Spirit of the Crane",
            197908 => "Mana Tea",
            264348 => "Tiger Tail Sweep",
            198898 => "Song of Chi-Ji",
            116844 => "Ring of Peace",
            122281 => "Healing Elixir",
            122783 => "Diffuse Magic",
            122278 => "Dampen Harm",
            115313 => "Summon Jade Serpent Statue",
            196725 => "Refreshing Jade Wind",
            198664 => "Invoke Chi-Ji, the Red Crane",
            197895 => "Focused Thunder",
            274963 => "Upwelling",
            274909 => "Rising Mist",
        );
    }

    public static function get_monk_class_windwalker_spec_mythicplus_spec(): string
    {
        return 'spec_2';
    }

    public static function get_monk_class_windwalker_spec_talents(): array
    {
        return array(
            196607, 115098, 123986, // Eye of the Tiger, Chi Wave, Chi Burst
            115173, 115008, 116841, // Celerity, Chi Torpedo, Tiger's Lust
            115396, 261947, 115288, // Ascension, Fist of the White Tiger, Energizing Elixir
            264348, 280195, 116844, // Tiger Tail Sweep, Good Karma, Ring of Peace
            261767, 122783, 122278, // Inner Strength, Diffuse Magic, Dampen Harm
            196740, 116847, 123904, // Hit Combo, Rushing Jade Wind, Invoke Xuen, the White Tiger
            280197, 152175, 152173, // Spiritual Focus, Whirling Dragon Punch, Serenity
            196607, 115098, 123986, // Eye of the Tiger, Chi Wave, Chi Burst
        );
    }

    public static function get_monk_class_windwalker_spec_talent_names(): array
    {
        return array(
            196607 => "Eye of the Tiger",
            115098 => "Chi Wave",
            123986 => "Chi Burst",
            115173 => "Celerity",
            115008 => "Chi Torpedo",
            116841 => "Tiger's Lust",
            115396 => "Ascension",
            261947 => "Fist of the White Tiger",
            115288 => "Energizing Elixir",
            264348 => "Tiger Tail Sweep",
            280195 => "Good Karma",
            116844 => "Ring of Peace",
            261767 => "Inner Strength",
            122783 => "Diffuse Magic",
            122278 => "Dampen Harm",
            196740 => "Hit Combo",
            116847 => "Rushing Jade Wind",
            123904 => "Invoke Xuen, the White Tiger",
            280197 => "Spiritual Focus",
            152175 => "Whirling Dragon Punch",
            152173 => "Serenity",
        );
    }
}
