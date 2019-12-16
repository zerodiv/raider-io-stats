<?php

namespace RaiderIO\CharacterClass;

class DemonHunter
{
    public static function get_demon_hunter_class_havoc_spec_mythicplus_spec(): string
    {
        return 'spec_0';
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

    public static function get_demon_hunter_class_havoc_spec_talent_names(): array
    {
        return array(
            203550 => "Blind Fury",
            206478 => "Demonic Appetite",
            232893 => "Felblade",
            258876 => "Insatiable Hunger",
            203555 => "Demon Blades",
            258920 => "Immolation Aura",
            258881 => "Trail of Ruin",
            192939 => "Fel Mastery",
            258925 => "Fel Barrage",
            204909 => "Soul Rending",
            205411 => "Desperate Instincts",
            196555 => "Netherwalk",
            258887 => "Cycle of Hatred",
            206416 => "First Blood",
            258860 => "Dark Slash",
            206477 => "Unleashed Power",
            203556 => "Master of the Glaive",
            211881 => "Fel Eruption",
            213410 => "Demonic",
            206476 => "Momentum",
            206491 => "Nemesis"
        );
    }

    public static function get_demon_hunter_class_vengeance_spec_mythicplus_spec(): string
    {
        return 'spec_1';
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

    public static function get_demon_hunter_class_vengeance_spec_talent_names(): array
    {
        return array(
            207550 => "Abyssal Strike",
            207548 => "Agonizing Flames",
            209400 => "Razor Spikes",
            207697 => "Feast of Souls",
            227174 => "Fallout",
            207739 => "Burning Alive",
            227322 => "Flame Crash",
            264002 => "Charred Flesh",
            232893 => "Fellblade",
            217996 => "Soul Rending",
            218612 => "Feed the Demon",
            263642 => "Fracture",
            207666 => "Concentrated Sigils",
            209281 => "Quickened Sigils",
            202138 => "Sigil of Chains",
            264004 => "Gluttony",
            247454 => "Spirit Bomb",
            212084 => "Fel Devastation",
            209258 => "Last Resort",
            268175 => "Void Reaver",
            263648 => "Soul Barrier"
        );
    }
}
