<?php

namespace RaiderIO\MythicPlus\SpecStats\Leaderboard\DoAnalysis\HtmlWriter;

use RaiderIO\MythicPlus\SpecStats\Leaderboard\DoAnalysis\HtmlWriter;
use RaiderIO\MythicPlus\SpecStats\Leaderboard\DoAnalysis\ByRoleLeaders;

class HtmlByRoleLeaders
{
    const TOP_CLASSES_DISPLAY = 5;
    
    public static function create(HtmlWriter $writer): string
    {
        $buffer = '';

        $roleLeaders = new ByRoleLeaders();
        $bucketData = $roleLeaders->getRoleBucketedData($writer->getAnalysisStack());

        $buffer .= sprintf(
            '<h3>Overall leaderboard by role and mythic+ range (top %d):</h3>',
            self::TOP_CLASSES_DISPLAY
        );

        $buffer .= '<center><table>' . "\n";

        $rangeRow = '<tr>';
        $rangeRow .= '<th rowspan="2">&nbsp;</th>';

        $classRanCountRow = '<tr>';

        foreach ($roleLeaders->getRanges() as $range) {
            $rangeRow .= '<th colspan="2">' . $range . '</th>';
            $classRanCountRow .=
                '<th>Class - Spec</th>'.
                '<th>Run Count</th>'
            ;
        }
        $rangeRow .= '</tr>';
        $classRanCountRow .= '</tr>';

        $buffer .= $rangeRow;
        $buffer .= $classRanCountRow;

        
        foreach ($roleLeaders->getKeyRoles() as $role) {
            $row1 = '<tr>';
            $row1 .= sprintf(
                '<th rowspan="%d">%s</th>',
                self::TOP_CLASSES_DISPLAY,
                $role
            );

            $row2 = '<tr>';
            $row3 = '<tr>';
            $row4 = '<tr>';
            $row5 = '<tr>';

            if (! array_key_exists($role, $bucketData)) {
                continue;
            }
            
            $roleData = $bucketData[$role];

            foreach ($roleLeaders->getRanges() as $range) {
                $rangeData = $roleData[$range];

                // put the stack into a solid order.
                arsort($rangeData, SORT_NUMERIC);

                $shownCount = 0;
        
                foreach ($rangeData as $classString => $ranCount) {
                    $pregs = array();
                    if ($shownCount < self::TOP_CLASSES_DISPLAY && preg_match('/(.*)_class_(.*)_spec/', $classString, $pregs)) {
                        $shownCount++;
                        $class = str_replace('_', '-', $pregs[1]);
                        $spec = str_replace('_', '-', $pregs[2]);
                        $rowName = 'row' . $shownCount;
                        
                        ${ $rowName } .= sprintf(
                            '<td>%d) %s - %s</td>',
                            $shownCount,
                            $class,
                            $spec
                        );

                        ${ $rowName } .=  sprintf(
                            '<td>%d</td>',
                            $ranCount
                        );
                    }
                }

                $buffer .= '</td>';
            }
            $row1 .= '</tr>';
            $row2 .= '</tr>';
            $row3 .= '</tr>';

            $buffer .= $row1 . $row2 . $row3 . $row4 . $row5;
        }
        $buffer .= '</table></center>' . "\n";

        return $buffer;
    }
}
