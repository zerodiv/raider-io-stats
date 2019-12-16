<?php

namespace RaiderIO\CharacterClass;

class DeathKnight
{
    public static function get_death_knight_class_blood_spec_mythicplus_spec(): string
    {
        return 'spec_0';
    }
    
    public static function get_death_knight_class_blood_spec_talents(): array
    {
        return array(
            221536, 206931, 210764, // Heartbreaker, Blooddrinker, Rune Strike
            194662, 273946, 274156, // Rapid Decomposition, Hemostasis, Consumption
            206974, 219786, 219809, // Fould bulwark, ossuary, tombstone
            206967, 205727, 194679, // Will of the Necropolis, Anti-Magic Barrier, Rune Tap
            273952, 206970, 212552, // Grip of the Dead, Tightening Grasp, Wraith Walk
            273953, 195679, 206940, // Voracious, Bloodworms, Mark of Blood
            114556, 205723, 194844  // Purgatory, Red Thirst, Bonestorm
        );
    }

    public static function get_death_knight_class_blood_spec_talent_names(): array
    {
        return array(
            221536 => 'Heartbreaker',
            206931 => 'Blooddrinker',
            210764 => 'Rune Strike',
            194662 => 'Rapid Decomposition',
            273946 => 'Hemostasis',
            274156 => 'Consumption',
            206974 => 'Foul Bulwark',
            219786 => 'Ossuary',
            219809 => 'Tombstone',
            206967 => 'Will of the Necropolis',
            205727 => 'Anti-Magic Barrier',
            194679 => 'Rune Tap',
            273952 => 'Grip of the Dead',
            206970 => 'Tightening Grasp',
            212552 => 'Wraith Walk',
            273953 => 'Voracious',
            195679 => 'Bloodworms',
            206940 => 'Mark of Blood',
            114556 => 'Purgatory',
            205723 => 'Red Thirst',
            194844 => 'Bonestorm'
        );
    }

    public static function get_death_knight_class_frost_spec_mythicplus_spec(): string
    {
        return 'spec_1';
    }

    public static function get_death_knight_class_frost_spec_talents(): array
    {
        return array(
            253593, 194878, 281208, // Inexorable Assault, Icy Talons, Cold Heart
            207104, 207061, 57330,  // Runic Attenuation, Murderous Efficiency, Horn of Winter
            276079, 108194, 207167, // Death's Reach, Asphyxiate, Blinding Sleet
            207142, 194909, 207230, // Avalanche, Frozen Pulse, Frostscythe
            207200, 212552, 48743,  // Permafrost, Wraith Walk, Death Pact
            194912, 194913, 279302, // Gathering Storm, Glacial Advance, Frostwyrm's Fury
            207126, 281238, 152279, // Icecap, Obliteration, Breath of Sindragosa
        );
    }

    public static function get_death_knight_class_frost_spec_talent_names(): array
    {
        return array(
            253593 => "Inexorable Assault",
            194878 => "Icy Talons",
            281208 => "Cold Heart",
            207104 => "Runic Attenuation",
            207061 => "Murderous Efficiency",
            57330 => "Horn of Winter",
            276079 => "Death's Reach",
            108194 => "Asphyxiate",
            207167 => "Blinding Sleet",
            207142 => "Avalanche",
            194909 => "Frozen Pulse",
            207230 => "Frostscythe",
            207200 => "Permafrost",
            212552 => "Wraith Walk",
            48743 => "Death Pact",
            194912 => "Gathering Storm",
            194913 => "Glacial Advance",
            279302 => "Frostwyrm's Fury",
            207126 => "Icecap",
            281238 => "Obliteration",
            152279 => "Breath of Sindragosa",
        );
    }

    public static function get_death_knight_class_unholy_spec_mythicplus_spec(): string
    {
        return 'spec_2';
    }

    public static function get_death_knight_class_unholy_spec_talents(): array
    {
        return array(
            207272, 194916, 207311, // Infected Claws, All Will Serve, Clawing Shadows
            207264, 207269, 115989, // Bursting Sores, Ebon Fever, Unholy Blight
            273952, 276079, 108194, // Grip of the Dead, Death's Reach, Asphyxiate
            194917, 276023, 130736, // Pestilent Pustules, Harbinger of Doom, Soul Reaper
            207321, 212552, 48743,  // Spell Eater, Wraith Walk, Death Pact
            277234, 152280, 207317, // Pestilence, Defile, Epidemic
            276837, 207289, 49206   // Army of the Damned, Unholy Frenzy, Summon Gargoyle
        );
    }

    public static function get_death_knight_class_unholy_spec_talent_names(): array
    {
        return array(
            207272 => "Infected Claws",
            194916 => "All Will Serve",
            207311 => "Clawing Shadows",
            207264 => "Bursting Sores",
            207269 => "Ebon Fever",
            115989 => "Unholy Blight",
            273952 => "Grip of the Dead",
            276079 => "Death's Reach",
            108194 => "Asphyxiate",
            194917 => "Pestilent Pustules",
            276023 => "Harbinger of Doom",
            130736 => "Soul Reaper",
            207321 => "Spell Eater",
            212552 => "Wraith Walk",
            48743 => "Death Pact",
            277234 => "Pestilence",
            152280 => "Defile",
            207317 => "Epidemic",
            276837 => "Army of the Damned",
            207289 => "Unholy Frenzy",
            49206 => "Summon Gargoyle"
        );
    }
}
