<?php 

namespace RaiderIO;

class CharacterClass {

    private static $_classNames = array(
        'mage' => true
    );

    private static $_classSpecs = array(
        'mage' => array(
            'frost' => true 
            )
    );

    private static $_activeClassesAndSpecs = array(
        'mage' => array( 'frost' )
    );

    public static function getActiveClassesAndSpecs() {
        return self::$_activeClassesAndSpecs;
    }
    
    public static function isValidClass(string $class): bool {
        return array_key_exists($class, self::$_classNames);
    }

    public static function isValidClassSpecCombo(string $class, string $spec): bool {

        if ( array_key_exists($class, self::$_classSpecs) != true ) {
            return false;
        }

        return array_key_exists($spec, self::$_classSpecs[$class]);

    }

}