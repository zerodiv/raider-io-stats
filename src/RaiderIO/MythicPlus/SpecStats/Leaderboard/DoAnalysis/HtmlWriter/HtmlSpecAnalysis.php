<?php

namespace RaiderIO\MythicPlus\SpecStats\Leaderboard\DoAnalysis\HtmlWriter;

use RaiderIO\MythicPlus\SpecStats\Leaderboard\DoAnalysis\HtmlWriter;
use RaiderIO\MythicPlus\SpecStats\Leaderboard\DoAnalysis;

use RaiderIO\CharacterClass;
use RaiderIO\Essences;

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
        
        // put a title within the div
        $buffer .= sprintf(
            '<a name="%s_%s"><h3>%s %s - overall stats</h3></a>',
            str_replace('-', '_', $class),
            $spec,
            ucwords(str_replace('-', ' ', $spec)),
            ucwords(str_replace('-', ' ', $class)),
        );
        
        $buffer .= '<center><table border="0" width="100%" >';
        
        $buffer .= '<tr>';
        
        $buffer .= '<td style="border:0; background-color: transparent;" width="33%">';
        $buffer .= self::mplusByRange($ana);
        $buffer .= '</td>';

        $buffer .= '<td style="border: 0; background-color: transparent;" width="33%">';
        $buffer .= self::essencesUsed($ana);
        $buffer .= '</td>';

        $buffer .= '<td style="border: 0; background-color: transparent;" width="33%">';
        $buffer .= self::dataset($ana);
        $buffer .= '</td>';
        
        $buffer .= '</tr>';

        $buffer .= '</table></center>';
        
        $buffer .= self::talentAnalysis($ana);

        $buffer .= '</div>' . "\n";

        return $buffer;
    }

    public static function mplusByRange(DoAnalysis $ana): string
    {
        $runCount =  $ana->getMythicPlusStats()->getRunCount();
        $runsByLevelBucketed = $ana->getMythicPlusStats()->getRunsByLevelBucketed();
        
        $buffer = '';
        $buffer .= '<center><table>';
        $buffer .= '<tr><th>M+ Level Range</th><th>Pct</th></tr>';

        foreach ($runsByLevelBucketed as $levelRange => $ranAmount) {
            $buffer .= sprintf(
                "<tr><td>%s</td><td>%d (%d%%)</td></tr>",
                $levelRange,
                $ranAmount,
                $ana->calculatePct($ranAmount, $runCount)
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
        $primarySlot = $ana->getNeckTraitStats()->getPrimarySlot();
        $secondarySlot = $ana->getNeckTraitStats()->getSecondarySlot();
        
        $primaryCount = $ana->getNeckTraitStats()->getPrimarySlotCount();
        $secondaryCount = $ana->getNeckTraitStats()->getSecondarySlotCount();
        
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

        $buffer = '';
        $buffer .= '<center><table>';
        $buffer .= '<tr>';
        $buffer .= '<th colspan="2">Primary Essences</th>';
        $buffer .= '<th colspan="2">Secondary Essences</th>';
        $buffer .= '</tr>';
        $buffer .= '<tr>';
        $buffer .= '<th>Name:</th>';
        $buffer .= '<th>Pct:</th>';
        $buffer .= '<th>Name:</th>';
        $buffer .= '<th>Pct:</th>';
        $buffer .= '</tr>';
        $buffer .= $row1 . $row2 . $row3;
        $buffer .= '</table></center>';
        
        return $buffer;
    }

    public static function dataset(DoAnalysis $ana): string
    {
        $buffer = '';
        $buffer .= '<center><table>';
        $buffer .= '<tr><th colspan="2">Dataset used</th></tr>';
        
        $buffer .= sprintf(
            '<tr><td>%s</td><td>%d (%d%%)</td></tr>',
            'Characters',
            $ana->getCharacterCount(),
            $ana->calculatePct($ana->getCharacterCount(), $ana->getPossibleCount()),
        );

        $buffer .= sprintf(
            '<tr><td>%s</td><td>%d (%d%%)</td></tr>',
            'Unavailable (due to spec switch)',
            $ana->getUnavailableCount(),
            $ana->calculatePct($ana->getUnavailableCount(), $ana->getPossibleCount()),
        );

        $buffer .= sprintf(
            '<tr><td>%s</td><td>%d</td></tr>',
            'Leaderboard',
            $ana->getPossibleCount()
        );
        
        $buffer .= '</table></center>';
        return $buffer;
    }

    public static function talentAnalysis(DoAnalysis $ana): string
    {
        $class = $ana->getClass();
        $spec = $ana->getSpec();

        $buffer = '';

        $badSpecCount = $ana->getTalentStats()->getBadSpecCount();
        $talentCount = $ana->getTalentStats()->getCharacterCount();

        $talentStats = $ana->getTalentStats()->getTalentStats($ana->getClass(), $ana->getSpec());
        $talents = CharacterClass::getTalentsForClassSpec($ana->getClass(), $ana->getSpec());

        $buffer .= sprintf(
            '<h3>%s %s - Talent choices for characters surveyed:</h3>',
            ucwords(str_replace('-', ' ', $spec)),
            ucwords(str_replace('-', ' ', $class)),
            $spec
        );

        $buffer .= '<center>';
        
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

        $talentLevels = array('15', '30', '45', '60', '75', '90', '100');

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

            if ($col == 3) {
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
        
        $buffer .= '</table></center>';

        return $buffer;
    }
}
