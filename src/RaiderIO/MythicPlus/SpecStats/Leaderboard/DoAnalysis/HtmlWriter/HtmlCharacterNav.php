<?php

namespace RaiderIO\MythicPlus\SpecStats\Leaderboard\DoAnalysis\HtmlWriter;

use RaiderIO\MythicPlus\SpecStats\Leaderboard\DoAnalysis\HtmlWriter;
use RaiderIO\CharacterClass;

class HtmlCharacterNav
{
    public static function create(HtmlWriter $writer): string
    {
        // create a navigation block for jumping around per char / spec
        $buffer = '<h1>Character and Talent Spec Stats</h1>' . "\n";
    
        $buffer = '<table border="1" width="100%">' . "\n";
    
        foreach (CharacterClass::getActiveClassesAndSpecs() as $class => $specs) {
            $buffer .= '<th>' . ucwords(str_replace('-', ' ', $class)) . '</th>' . "\n";
        }
    
        $buffer .= '</tr>';
    
        foreach (CharacterClass::getActiveClassesAndSpecs() as $class => $specs) {
            $buffer .= '<td>';
            foreach ($specs as $spec) {
                $buffer .= sprintf(
                    '<b>&#8226;<a href="#%s_%s" onClick="switchClass(\'#%s_%s\'); return false;">%s</a></b><br/>',
                    str_replace('-', '_', $class),
                    $spec,
                    str_replace('-', '_', $class),
                    $spec,
                    $spec
                );
            }
            $buffer .= '</td>' . "\n";
        }
    
        $buffer .= '</table>' . "\n";
        
        return $buffer;
    }
}
