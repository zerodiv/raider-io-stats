<?php

namespace RaiderIO\MythicPlus\SpecStats\Leaderboard\DoAnalysis\HtmlWriter;

use RaiderIO\MythicPlus\SpecStats\Leaderboard\DoAnalysis\HtmlWriter;
use RaiderIO\MythicPlus\SpecStats\Leaderboard\DoAnalysis;

use RaiderIO\CharacterClass;
use RaiderIO\Essences;
use RaiderIO\MythicPlus\Ranges;

class HtmlSpecAnalysis
{
    public static function create(HtmlWriter $writer, DoAnalysis $ana): string
    {
        $class = $ana->getClass();
        $spec  = $ana->getSpec();

        $buffer = '';

        // create the div
        $buffer .= sprintf(
            '<div id="%s_%s">' . "\n",
            str_replace('-', '_', $class),
            str_replace('-', '_', $spec)
        );
               
        $buffer .= self::talentAnalysis($ana);

        $buffer .= self::essencesUsed($ana);

        $buffer .= self::itemAnalysis($ana);
        
        $buffer .= '</div>' . "\n";

        return $buffer;
    }

    public static function mplusByRange(DoAnalysis $ana): string
    {
        $characterCount  =  $ana->getMythicPlusStats()->getRunnerCount();
        $byLevelBucketed = $ana->getMythicPlusStats()->getRunnersByLevelBucketed();
        
        $buffer = '';
        $buffer .= '<center><table>';
        $buffer .= '<tr><th>M+ Level Range</th><th>Pct</th></tr>';

        foreach ($byLevelBucketed as $levelRange => $characters) {
            $buffer .= sprintf(
                "<tr><td>%s</td><td>%d (%d%%)</td></tr>",
                $levelRange,
                $characters,
                $ana->calculatePct($characters, $characterCount)
            );
        }
        
        $buffer .= '</table></center>';
        return $buffer;
    }

    public static function essenceUsed(DoAnalysis $ana, int $maxCount, array $essences, string $row1, string $row2, string $row3): array
    {
        $shown = 0;

        foreach ($essences as $essenceId => $useCount) {
            $pct = $ana->calculatePct($useCount, $maxCount);

            $shown++;

            // we don't support anything past 3 rows here.
            if ($shown > 3) {
                continue;
            }
                    
            $rowVar = 'row' . $shown;

            $essence = Essences::getById($essenceId);
            $essenceName = $essence->getName();

            // aegis-of-the-deep-96#azerite-essence
            ${$rowVar} .= sprintf(
                '<td>%d) <a href="https://www.wowhead.com/azerite-essence/%s#azerite-essence">%s</a></td>' .
                '<td>%d (%d%%)</td>',
                $shown,
                strtolower(str_replace(' ', '-', $essenceName) . '-' . $essenceId),
                $essenceName,
                $useCount,
                $pct
            );
        }

        return array($row1, $row2, $row3);
    }

    public static function essencesUsed(DoAnalysis $ana): string
    {
        $class = $ana->getClass();
        $spec = $ana->getSpec();

        $buffer = '';
        
        $buffer .= sprintf(
            '<h3>%s %s - Essences used for characters surveyed:</h3>',
            ucwords(str_replace('-', ' ', $spec)),
            ucwords(str_replace('-', ' ', $class)),
            $spec
        );

        $ranger = new HtmlByRange($ana, 'neck_essences');

        $buffer .= '<center>';
        $buffer .= $ranger->getNavigationTable();

        foreach (Ranges::getRanges() as $range) {
            $primarySlot = $ana->getNeckTraitStats()->getPrimarySlot($range);
            $secondarySlot = $ana->getNeckTraitStats()->getSecondarySlot($range);
            
            $primaryCount = $ana->getNeckTraitStats()->getPrimarySlotCount($range);
            $secondaryCount = $ana->getNeckTraitStats()->getSecondarySlotCount($range);
            
            arsort($primarySlot, SORT_NUMERIC);
            arsort($secondarySlot, SORT_NUMERIC);
            
            $row1 = '<tr>';
            $row2 = '<tr>';
            $row3 = '<tr>';
    
            list($row1, $row2, $row3) = self::essenceUsed($ana, $primaryCount, $primarySlot, $row1, $row2, $row3);
            list($row1, $row2, $row3) = self::essenceUsed($ana, $secondaryCount, $secondarySlot, $row1, $row2, $row3);
            
            $row1 .= '</tr>';
            $row2 .= '</tr>';
            $row3 .= '</tr>';
    
            $inner_div_name = $ranger->getInnerDivName($range);

            $buffer .= sprintf(
                '<div id="%s">',
                $inner_div_name
            );

            $buffer .= '<table>';
            $buffer .= '<tr><th colspan="4">Neck Essences</th></tr>';
            $buffer .= '<tr>';
            $buffer .= '<th colspan="2">Primary</th>';
            $buffer .= '<th colspan="2">Secondary</th>';
            $buffer .= '</tr>';
            $buffer .= '<tr>';
            $buffer .= '<th>Name:</th>';
            $buffer .= '<th>Pct:</th>';
            $buffer .= '<th>Name:</th>';
            $buffer .= '<th>Pct:</th>';
            $buffer .= '</tr>';
            $buffer .= $row1 . $row2 . $row3;
            $buffer .= '</table>';
            $buffer .= '</div>';
        }

        $buffer .= $ranger->addDefaultSwitch();
        $buffer .= '<hr>';
        $buffer .= '</center>';
        
        return $buffer;
    }

    public static function talentAnalysis(DoAnalysis $ana): string
    {
        $class = $ana->getClass();
        $spec = $ana->getSpec();

        $buffer = '';
        $buffer .= "<!-- start spec analysis section -->\n";
        $allCount = $ana->getTalentStats()->getAllCharacterCount();

        $talents = CharacterClass::getTalentsForClassSpec($ana->getClass(), $ana->getSpec());

        $buffer .= sprintf(
            '<h3>%s %s - Talent choices for characters surveyed:</h3>',
            ucwords(str_replace('-', ' ', $spec)),
            ucwords(str_replace('-', ' ', $class)),
            $spec
        );

        $buffer .= '<center>';
        
        $ranger = new HtmlByRange($ana, 'talent_range');

        $buffer .= $ranger->getNavigationTable();

        foreach (Ranges::getRanges() as $range) {
            $inner_div_name = $ranger->getInnerDivName($range);

            $buffer .= sprintf(
                '<div id="%s">',
                $inner_div_name
            );
            
            $badSpecCount = $ana->getTalentStats()->getBadSpecCount($range);
            $talentCount = $ana->getTalentStats()->getCharacterCount($range);

            $talentStats = $ana->getTalentStats()->getTalentStats($ana->getClass(), $ana->getSpec(), $range);
       
            $buffer .= '<table>';

            $buffer .= '<tr>';
            $buffer .= '<th>Level</th>';
            $buffer .= '<th>Talent</th>';
            $buffer .= '<th>Usage Pct</th>';
        
            $buffer .= '<th>Talent</th>';
            $buffer .= '<th>Usage Pct</th>';

        
            $buffer .= '<th>Talent</th>';
            $buffer .= '<th>Usage Pct</th>';

            $buffer .= '</tr>';

            $col = 0;
            $row = array();
            $talentMarkup = array();
            foreach ($talents as $spellId) {
                $col++;

                $row[] = $spellId;

                if ($col == 3) {
                    //var_dump($row);

                    $rowMap = array();
                    foreach ($row as $spellId) {
                        $rowMap[$spellId] = $talentStats[$spellId];
                    }
                    //var_dump($rowMap);

                    // now we have a talent row, sort it
                    arsort($rowMap, SORT_NUMERIC);
                
                    $offset = 0;
                    foreach ($rowMap as $spellId => $count) {
                        $offset++;
                        $talentMarkup[$spellId] = $offset;
                    }

                    //var_dump($talentMarkup);
                
                    $col = 0;
                    $row = array();
                }
            }

            $talentLevels = array(
            0 => '15',
            1 => '30',
            2 => '45',
            3 => '60',
            4 => '75',
            5 => '90',
            6 => '100'
        );

            $col = 0;
            $row = '';
            $talentLevel = 0;
            foreach ($talents as $spellId) {
                $col++;

                // they all start out bad ;)
                $talentCss = 'badTalent';
                $talentScore = 3;
                if ($talentMarkup[$spellId] == 2) {
                    $talentCss = 'marginalTalent';
                    $talentScore = 2;
                } elseif ($talentMarkup[$spellId] == 1) {
                    $talentCss = 'goodTalent';
                    $talentScore = 1;
                }

                $row .= sprintf(
                    '<td class="%s">%d) <a href="https://www.wowhead.com/spell=%d"><b>%s</b></a></td><td class="%s">%-10d (%3d%%)</td>',
                    $talentCss,
                    $talentScore,
                    $spellId,
                    CharacterClass::resolveTalentToName($spellId),
                    $talentCss,
                    $talentStats[$spellId],
                    $ana->calculatePct($talentStats[$spellId], $talentCount)
                );

                if ($col == 3 && array_key_exists($talentLevel, $talentLevels)) {
                    $talentHeader = '<th>' . $talentLevels[$talentLevel] . '</th>';
                    $buffer .= '<tr>' . $talentHeader . $row . "</tr>\n";
                    $col = 0;
                    $row = '';
                    $talentLevel++;
                }
            }

            $buffer .= '<tr><th colspan="7"><hr></th></tr>';
            $buffer .= '<tr>';
            $buffer .= '<th>Legend</th>';
            $buffer .= '<td colspan="2" class="goodTalent"><center>Good / Highly Used</center></td>';
            $buffer .= '<td colspan="2" class="marginalTalent"><center>Marginal / Situational</center></td>';
            $buffer .= '<td colspan="2" class="badTalent"><center>Bad</center></td>';
            $buffer .= '</tr>';
        
            $buffer .= '</table>';
            $buffer .= '</div>';
        }
        $buffer .= '<hr>';
        $buffer .= '</center>';
        $buffer .= $ranger->addDefaultSwitch();
        $buffer .= "<!-- end spec analysis section -->\n";
        return $buffer;
    }

    public static function itemAnalysis(DoAnalysis $ana): string
    {
        $class = $ana->getClass();
        $spec = $ana->getSpec();
        
        $count = $ana->getItemStats()->getCount();
        $items = $ana->getItemStats()->getItems();

        $content = '';

        $titleRow = '';
        $row1 = '';
        $row2 = '';
        $row3 = '';
        $row4 = '';
        $row5 = '';

        $slotCount = 0;

        foreach ($items as $slot => $itemUsage) {
            if ($slotCount != 0 && ($slotCount % 5) == 0) {
                if ($content != '') {
                    $content .= '<br/>';
                }
                
                $content .= sprintf(
                    '<table>' .
                    '  <tr>%s</tr>' .
                    '  <tr>%s</tr>' .
                    '  <tr>%s</tr>' .
                    '  <tr>%s</tr>' .
                    '  <tr>%s</tr>' .
                    '  <tr>%s</tr>' .
                    '</table>' . "\n",
                    $titleRow,
                    $row1,
                    $row2,
                    $row3,
                    $row4,
                    $row5,
                );

                $titleRow = '';
                $row1 = '';
                $row2 = '';
                $row3 = '';
                $row4 = '';
                $row5 = '';
            }

            $slotCount++;
            

            
            $titleRow .= '<th colspan="2">' . ucfirst($slot) . '</th>';
            
            arsort($itemUsage, SORT_NUMERIC);
            
            $showCount = 0;
            foreach ($itemUsage as $itemId => $usageCount) {
                $showCount++;

                if ($showCount > 5) {
                    continue;
                }
                
                $pct = $ana->calculatePct($usageCount, $count);

                $rowVar = 'row' . $showCount;

                ${ $rowVar } .= sprintf(
                    '<td>%d) <a href="https://www.wowhead.com/?item=%d" data-wowhead="item=%d">wowhead-provided-item-name</a></td>' .
                    '<td>%d (%d%%)</td>',
                    $showCount,
                    $itemId,
                    $itemId,
                    $usageCount,
                    $pct
                );
            }

            if ($slot == 'neck') {
                $row2 .= '<td colspan="2">&nbsp;</td>';
                $row3 .= '<td colspan="2">&nbsp;</td>';
                $row4 .= '<td colspan="2">&nbsp;</td>';
                $row5 .= '<td colspan="2">&nbsp;</td>';
            }
        }

        if ($titleRow != '') {
            if ($content != '') {
                $content .= '<br/>';
            }
            
            $content .= sprintf(
                '<table>' .
                '  <tr>%s</tr>' .
                '  <tr>%s</tr>' .
                '  <tr>%s</tr>' .
                '  <tr>%s</tr>' .
                '  <tr>%s</tr>' .
                '  <tr>%s</tr>' .
                '</table>' . "\n",
                $titleRow,
                $row1,
                $row2,
                $row3,
                $row4,
                $row5,
            );
        }

        $buffer = '';

        $buffer .= sprintf(
            '<h3>%s %s - Item analysis:</h3>',
            ucwords(str_replace('-', ' ', $spec)),
            ucwords(str_replace('-', ' ', $class)),
            $spec
        );

        $buffer .= '<center>';
        $buffer .= $content;
        $buffer .= '</center>';

        return $buffer;
    }
}
