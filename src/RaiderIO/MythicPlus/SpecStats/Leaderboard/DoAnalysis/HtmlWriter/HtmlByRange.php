<?php

namespace RaiderIO\MythicPlus\SpecStats\Leaderboard\DoAnalysis\HtmlWriter;

class HtmlByRange
{
    public static function getSwitchFunctionName(string $section): string
    {
        return sprintf(
            '%s_%s_switchTalents',
            str_replace('-', '_', $class),
            str_replace('-', '_', $spec),
        );
    }
    
    public static function getByRangeNavJavascript(): string
    {
        $buffer = '<script>';
        
        $buffer .= sprintf(
            "function %s(range) {\n",
            $switchFunctionName
        );

        $buffer .= '</script>';
    }
}
