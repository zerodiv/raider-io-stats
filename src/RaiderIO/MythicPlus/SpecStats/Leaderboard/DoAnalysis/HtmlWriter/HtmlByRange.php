<?php

namespace RaiderIO\MythicPlus\SpecStats\Leaderboard\DoAnalysis\HtmlWriter;

use RaiderIO\MythicPlus\SpecStats\Leaderboard\DoAnalysis;
use RaiderIO\MythicPlus\Ranges;

class HtmlByRange
{
    private DoAnalysis $_ana;
    private string $_section;

    public function __construct(DoAnalysis $ana, string $section)
    {
        $this->_ana = $ana;
        $this->_section = $section;
    }

    public function getSwitchFunctionName(): string
    {
        $class = $this->_ana->getClass();
        $spec = $this->_ana->getSpec();

        return sprintf(
            '%s_%s_switch_%s',
            str_replace('-', '_', $class),
            str_replace('-', '_', $spec),
            $this->_section
        );
    }
    
    public function getInnerDivName(string $range)
    {
        $class = $this->_ana->getClass();
        $spec = $this->_ana->getSpec();

        return sprintf(
            '%s_class_%s_spec_%s_%s',
            str_replace('-', '_', $class),
            str_replace('-', '_', $spec),
            str_replace('-', '_', $range),
            $this->_section
        );
    }

    public function getByRangeNavJavascript(): string
    {
        $buffer = '<script>';
        
        $buffer .= sprintf(
            "function %s(range) {\n",
            $this->getSwitchFunctionName($this->_section)
        );

        foreach (Ranges::getRanges() as $range) {
            $inner_div_name = $this->getInnerDivName($range);

            $buffer .= sprintf(
                '$("#%s_nav").removeClass("goodTalent");' . "\n",
                $inner_div_name
            );

            $buffer .= sprintf('$("#%s").hide();' . "\n", $inner_div_name);
        }

        $class = $this->_ana->getClass();
        $spec = $this->_ana->getSpec();

        $buffer .= sprintf(
            '$("#%s_class_%s_spec_" + range + "_%s_nav").addClass("goodTalent");' . "\n",
            str_replace('-', '_', $class),
            str_replace('-', '_', $spec),
            $this->_section
        );

        $buffer .= sprintf(
            '$("#%s_class_%s_spec_" + range + "_%s").show();' . "\n",
            str_replace('-', '_', $class),
            str_replace('-', '_', $spec),
            $this->_section
        );

        $buffer .= "}\n";

        $buffer .= '</script>';

        return $buffer;
    }

    public function getNavigationTable(): string
    {
        $buffer = '';
        $buffer .= $this->getByRangeNavJavascript();
        
        $switchFunctionName = $this->getSwitchFunctionName();
        
        $buffer .= '<table>';
        $buffer .= '<tr>';
        $buffer .= '<th>Mythic Range:</th>';

        $runnerCount =  $this->_ana->getMythicPlusStats()->getRunnerCount();
        $runsByLevelBucketed = $this->_ana->getMythicPlusStats()->getRunnersByLevelBucketed();

        foreach ($runsByLevelBucketed as $range => $runnersCount) {
            $inner_div_name = $this->getInnerDivName($range);
            
            // <a href="#%s_%s" onClick="switchClass(\'#%s_%s\');
            $buffer .= sprintf(
                '<th id="%s_nav"><a href="#%s_nav" onClick="%s(\'%s\')">%s - %d (%d%%)</a></th>',
                $inner_div_name,
                $inner_div_name,
                $switchFunctionName,
                str_replace('-', '_', $range),
                $range,
                $runnersCount,
                $this->_ana->calculatePct($runnersCount, $runnerCount)
            );
        }
        $buffer .= '</tr>';
        $buffer .= '</table>';
        $buffer .= '<br/>';
        return $buffer;
    }

    public function addDefaultSwitch(): string
    {
        $buffer = '';
        $switchFunctionName = $this->getSwitchFunctionName();
        $buffer .= '<script>' . $switchFunctionName . '("10_14");</script>';
        return $buffer;
    }
}
