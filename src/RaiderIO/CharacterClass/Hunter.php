<?php

namespace RaiderIO\CharacterClass;

class Hunter
{
    public static function get_hunter_class_beast_mastery_spec_mythicplus_spec(): string
    {
        return 'spec_0';
    }
    
    public static function get_hunter_class_beast_mastery_spec_talents(): array
    {
        return array(
            273887, 267116, 120679, // Killer Instinct, Animal Companion, Dire Beast
            193532, 199528, 53209, // Scent of Blood, One with the Pack, Chimaera Shot
            199921, 270581, 199483, // Trailblazer, Natural Mending, Camouflage
            257891, 257944, 131894, // Venomous Bite, Thrill of the Hunt, A Murder of Crows
            266921, 109215, 109248, // Born To Be Wild, Posthaste, Binding Shot
            199530, 120360, 201430, // Stomp, Barrage, Stampede
            191384, 199532, 194407 // Aspect of the Beast, Killer Cobra, Spitting Cobra
        );
    }

    public static function get_hunter_class_beast_mastery_spec_talent_names(): array
    {
        return array(
            273887 => "Killer Instinct",
            267116 => "Animal Companion",
            120679 => "Dire Beast",
            193532 => "Scent of Blood",
            199528 => "One with the Pack",
            53209 => "Chimaera Shot",
            199921 => "Trailblazer",
            270581 => "Natural Mending",
            199483 => "Camouflage",
            257891 => "Venomous Bite",
            257944 => "Thrill of the Hunt",
            131894 => "A Murder of Crows",
            266921 => "Born To Be Wild",
            109215 => "Posthaste",
            109248 => "Binding Shot",
            199530 => "Stomp",
            120360 => "Barrage",
            201430 => "Stampede",
            191384 => "Aspect of the Beast",
            199532 => "Killer Cobra",
            194407 => "Spitting Cobra"
        );
    }

    public static function get_hunter_class_marksmanship_spec_mythicplus_spec(): string
    {
        return 'spec_1';
    }

    public static function get_hunter_class_marksmanship_spec_talents(): array
    {
        return array(
            260309, 271788, 131894, // Master Marksman, Serpent Sting, A Murder of Crows
            260228, 260243, 212431, // Careful Aim, Volley, Explosive Shot
            199921, 270581, 199483, // Trailblazer, Natural Mending, Camouflage
            193533, 260367, 257284, // Steady Focus, Streamline, Hunter's Mark
            266921, 109215, 109248, // Born To Be Wild, Posthaste, Binding Shot
            260393, 120360, 260402, // Lethal Shots, Barrage, Double Tap
            260404, 194595, 198670 // Calling the Shots, Lock and Load, Piercing Shot
        );
    }

    public static function get_hunter_class_marksmanship_spec_talent_names(): array
    {
        return array(
            260309 => "Master Marksman",
            271788 => "Serpent Sting",
            131894 => "A Murder of Crows",
            260228 => "Careful Aim",
            260243 => "Volley",
            212431 => "Explosive Shot",
            199921 => "Trailblazer",
            270581 => "Natural Mending",
            199483 => "Camouflage",
            193533 => "Steady Focus",
            260367 => "Streamline",
            257284 => "Hunter's Mark",
            266921 => "Born To Be Wild",
            109215 => "Posthaste",
            109248 => "Binding Shot",
            260393 => "Lethal Shots",
            120360 => "Barrage",
            260402 => "Double Tap",
            260404 => "Calling the Shots",
            194595 => "Lock and Load",
            198670 => "Piercing Shot"
        );
    }

    public static function get_hunter_class_survival_spec_mythicplus_spec(): string
    {
        return 'spec_2';
    }

    public static function get_hunter_class_survival_spec_talents(): array
    {
        return array(
           268501, 265895, 269737, // Viper's Venom, Terms of Engagement, Alpha Predator
           264332, 260241, 212436, // Guerrilla Tactics, Hydra's Bite, Butchery
           199921, 270581, 199483, // Trailblazer, Natural Mending, Camouflage
           260248, 162488, 131894, // Bloodseeker, Steel Trap, A Murder of Crows
           266921, 109215, 109248, // Born To Be Wild, Posthaste, Binding Shot
           260285, 259387, 269751, // Tip of the Spear, Mongoose Bite, Flanking Strike
           260331, 271014, 259391, // Birds of Prey, Wildfire Infusion, Chakrams
        );
    }

    public static function get_hunter_class_survival_spec_talent_names(): array
    {
        return array(
            268501 => "Viper's Venom",
            265895 => "Terms of Engagement",
            269737 => "Alpha Predator",
            264332 => "Guerrilla Tactics",
            260241 => "Hydra's Bite",
            212436 => "Butchery",
            199921 => "Trailblazer",
            270581 => "Natural Mending",
            199483 => "Camouflage",
            260248 => "Bloodseeker",
            162488 => "Steel Trap",
            131894 => "A Murder of Crows",
            266921 => "Born To Be Wild",
            109215 => "Posthaste",
            109248 => "Binding Shot",
            260285 => "Tip of the Spear",
            259387 => "Mongoose Bite",
            269751 => "Flanking Strike",
            260331 => "Birds of Prey",
            271014 => "Wildfire Infusion",
            259391 => "Chakrams",
        );
    }
}
