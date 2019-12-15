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
}
