<?php

namespace RaiderIO\MythicPlus\SpecStats\Leaderboard\DoAnalysis;

use RaiderIO\HtmlDir;
use RaiderIO\CharacterClass;
use RaiderIO\MythicPlus\SpecStats\Leaderboard\DoAnalysis;

class HtmlWriter
{
    private array $_analysisStack = array();

    public function addAnalysis(DoAnalysis $ana): bool
    {
        $this->_analysisStack[] = $ana;
        return true;
    }

    public function createCharacterNav(): string
    {
        // create a navigation block for jumping around per char / spec
        $characterNav = '<h1>Character and Talent Spec Stats</h1>' . "\n";

        $characterNav = '<table border="1" width="100%">' . "\n";

        foreach (CharacterClass::getActiveClassesAndSpecs() as $class => $specs) {
            $characterNav .= '<th>' . ucwords(str_replace('-', ' ', $class)) . '</th>' . "\n";
        }

        $characterNav .= '</tr>';

        foreach (CharacterClass::getActiveClassesAndSpecs() as $class => $specs) {
            $characterNav .= '<td>';
            foreach ($specs as $spec) {
                $characterNav .= sprintf(
                    '<b>&#8226;<a href="#%s_%s" onClick="switchClass(\'#%s_%s\'); return false;">%s</a></b><br/>',
                    str_replace('-', '_', $class),
                    $spec,
                    str_replace('-', '_', $class),
                    $spec,
                    $spec
                );
            }
            $characterNav .= '</td>' . "\n";
        }

        $characterNav .= '</table>' . "\n";

        $roleLeaders = new ByRoleLeaders();
        $bucketData = $roleLeaders->getRoleBucketedData($this->_analysisStack);

        $characterNav .= '<h3>By role and mythic+ range (top 3):</h3>';

        $characterNav .= '<center><table>' . "\n";

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

        $characterNav .= $rangeRow;
        $characterNav .= $classRanCountRow;

        
        foreach ($roleLeaders->getKeyRoles() as $role) {
            $row1 = '<tr>';
            $row1 .= '<th rowspan="3">' . $role . '</th>';

            $row2 = '<tr>';

            $row3 = '<tr>';

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
                    if ($shownCount < 3 && preg_match('/(.*)_class_(.*)_spec/', $classString, $pregs)) {
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

                $characterNav .= '</td>';
            }
            $row1 .= '</tr>';
            $row2 .= '</tr>';
            $row3 .= '</tr>';

            $characterNav .= $row1 . $row2 . $row3;
        }
        $characterNav .= '</table></center>' . "\n";

        return $characterNav;
    }

    public function writeIndex()
    {
        $indexFile = HtmlDir::get() . '/index.html';

        echo "indexFile=$indexFile\n";
        $fh = fopen($indexFile, 'w');

        fwrite($fh, $this->makeHeaderBlock(''));
        fwrite($fh, $this->createCharacterNav());

        // --
        // Walk each spec for it's stats.
        // --
        foreach ($this->_analysisStack as $ana) {
            $this->addClassSpecAnalysis($fh, $ana);
        }
        
        fwrite($fh, $this->makeFooterBlock(''));
        fclose($fh);
    }

    public function addClassSpecAnalysis($fh, DoAnalysis $ana): bool
    {
        $class = $ana->getClass();
        $spec  = $ana->getSpec();

        $outputBuffer = '';

        $outputBuffer .= sprintf(
            '<div id="%s_%s">' . "\n",
            str_replace('-', '_', $class),
            str_replace('-', '_', $spec)
        );
        
        $outputBuffer .= sprintf(
            '<a name="%s_%s"><h3>%s: %s</h3></a>',
            str_replace('-', '_', $class),
            $spec,
            ucwords(str_replace('-', ' ', $class)),
            $spec
        );

        $outputBuffer .= '<center><table border="0" width="100%" >';
        
        $outputBuffer .= '<tr>';

        $runCount =  $ana->getMythicPlusStats()->getRunCount();
        $runsByLevelBucketed = $ana->getMythicPlusStats()->getRunsByLevelBucketed();
        
        $outputBuffer .= '<td style="border:0; background-color: transparent;" width="50%">';
        $outputBuffer .= '<center><table>';
        
        $outputBuffer .= '<tr><th>M+ Level Range</th><th>Pct</th></tr>';

        foreach ($runsByLevelBucketed as $levelRange => $ranAmount) {
            $outputBuffer .= sprintf(
                "<tr><td>%s</td><td>%d (%d%%)</td></tr>",
                $levelRange,
                $ranAmount,
                $ana->calculatePct($ranAmount, $runCount)
            );
        }
        $outputBuffer .= '</table></center>';
        $outputBuffer .= '</td>';

        $outputBuffer .= '<td style="border: 0; background-color: transparent;" width="50%">';
        $outputBuffer .= '<center><table>';
        $outputBuffer .= '<tr><th colspan="2">Dataset</th></tr>';
        
        $outputBuffer .= sprintf(
            '<tr><td>%s</td><td>%d (%d%%)</td></tr>',
            'Characters',
            $ana->getCharacterCount(),
            $ana->calculatePct($ana->getCharacterCount(), $ana->getPossibleCount()),
        );

        $outputBuffer .= sprintf(
            '<tr><td>%s</td><td>%d (%d%%)</td></tr>',
            'Unavailable (due to spec switch)',
            $ana->getUnavailableCount(),
            $ana->calculatePct($ana->getUnavailableCount(), $ana->getPossibleCount()),
        );

        $outputBuffer .= sprintf(
            '<tr><td>%s</td><td>%d</td></tr>',
            'Leaderboard',
            $ana->getPossibleCount()
        );
        
        $outputBuffer .= '</table></center>';
        $outputBuffer .= '</td>';
        
        $outputBuffer .= '</tr>';

        $outputBuffer .= '</table></center>';

        
        $badSpecCount = $ana->getTalentStats()->getBadSpecCount();
        $talentCount = $ana->getTalentStats()->getCharacterCount();

        $talentStats = $ana->getTalentStats()->getTalentStats($ana->getClass(), $ana->getSpec());
        $talents = CharacterClass::getTalentsForClassSpec($ana->getClass(), $ana->getSpec());

        $outputBuffer .= '<h4>Talent choices for all characters surveyed:</h4>';

        $outputBuffer .= '<center>';
        
        $outputBuffer .= '<table>';
        $outputBuffer .= '<tr><th colspan="3"><b>Legend:</th></tr>';
        $outputBuffer .= '<tr>';
        $outputBuffer .= '<td width="30%" class="goodTalent"><center>Good / Highly Used</center></td>';
        $outputBuffer .= '<td width="30%" class="marginalTalent"><center>Marginal / Situational</center></td>';
        $outputBuffer .= '<td width="30%" class="badTalent"><center>Bad</center></td>';
        $outputBuffer .= '</table>';
        
        $outputBuffer .= '<br>';

        $outputBuffer .= '<table width="100%">';

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

        $col = 0;
        $row = '<tr>';
        foreach ($talents as $spellId) {
            $col++;

            // they all start out bad ;)
            $talentCss = 'badTalent';
            if ($talentMarkup[$spellId] == 2) {
                $talentCss = 'marginalTalent';
            } elseif ($talentMarkup[$spellId] == 1) {
                $talentCss = 'goodTalent';
            }

            $row .= sprintf(
                '<td class="%s"><a href="https://www.wowhead.com/spell=%d"><b>%s</b></a></td><td class="%s">%-10d (%3d%%)</td>',
                $talentCss,
                $spellId,
                CharacterClass::resolveTalentToName($spellId),
                $talentCss,
                $talentStats[$spellId],
                $ana->calculatePct($talentStats[$spellId], $talentCount)
            );

            if ($col == 3) {
                $outputBuffer .= $row . "</tr>\n";
                $row = '<tr>';
                $col = 0;
            }
        }


        
        $outputBuffer .= '</table></center>';

        $outputBuffer .= '</div>' . "\n";

        fwrite($fh, $outputBuffer);

        return true;
    }

    public function makeHeaderBlock(string $title = ''): string
    {
        $titleString = 'RaiderIO Stats';

        if ($title !== '') {
            $titleString = ': ' . $title;
        }

        //var_dump($titleString);

        return <<<HEADER
<!doctype html>
<html lang="en-US">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
        
<title>$titleString| zerodiv.github.io</title>
<meta property="og:locale" content="en_US" />
<link href="https://thomasf.github.io/solarized-css/solarized-dark.min.css" rel="stylesheet"></link>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script>var whTooltips = {colorLinks: false, iconizeLinks: true, renameLinks: true};</script>
<script src="https://wow.zamimg.com/widgets/power.js"></script>
<style>
body {
    max-width: none;
}

td, th {
    border: 1px solid white;
    background-color: #268bd2;
    color: #000000;
    padding: 6px;  
}
th {
  background: #b58900;
  color: #000000;
  font-weight: bold;
}
.goodTalent {
    background-color: #268bd2;
    color: #000000;
    font-weight: bold;
}
.marginalTalent {
    background-color: #2aa198;
    color: #000000;
    font-weight: bold;
}
.badTalent {
    background-color: #6c71c4;
    color: #000000;
    font-weight: bold;
}

td a, a:visited {
    color: #000000;
}

</style>
<script>

function switchClass(className) {
    $("#death_knight_blood").hide();
    $("#death_knight_frost").hide();
    $("#death_knight_unholy").hide();
    $("#demon_hunter_havoc").hide();
    $("#demon_hunter_vengeance").hide();
    $("#druid_balance").hide();
    $("#druid_feral").hide();
    $("#druid_guardian").hide();
    $("#druid_restoration").hide();
    $("#hunter_beast_mastery").hide();
    $("#hunter_marksmanship").hide();
    $("#hunter_survival").hide();
    $("#mage_arcane").hide();
    $("#mage_fire").hide();
    $("#mage_frost").hide();
    $("#monk_brewmaster").hide();
    $("#monk_mistweaver").hide();
    $("#monk_windwalker").hide();
    $("#paladin_holy").hide();
    $("#paladin_protection").hide();
    $("#paladin_retribution").hide();
    $("#priest_discipline").hide();
    $("#priest_holy").hide();
    $("#priest_shadow").hide();
    $("#rogue_assassination").hide();
    $("#rogue_outlaw").hide();
    $("#rogue_subtlety").hide();
    $("#shaman_elemental").hide();
    $("#shaman_enhancement").hide();
    $("#shaman_restoration").hide();
    $("#warlock_affliction").hide();
    $("#warlock_demonology").hide();
    $("#warlock_destruction").hide();
    $("#warrior_arms").hide();
    $("#warrior_fury").hide();
    $("#warrior_protection").hide();
    $(className).show();
}
</script>

</head>
<body>

<div id="title">
  <h1>$titleString</h1>
</div>

HEADER;
    }

    public function makeFooterBlock(): string
    {
        return <<<'FOOTER'
        <div id="footer">
        <hr>  
        <center>
        <table>
        <tr>
        <th colspan="4">Credits:</th>
        </tr>
        <tr>
        <td><a href="https://raider.io/">Raider IO</a></td>
        <td><a href="https://www.icy-veins.com/">Icy Veins</a></td>
        <td><a href="http://www.github.com">Hosted on GitHub Pages</a></td>
        <td><a href="https://thomasf.github.io/solarized-css/">Solarized Dark CSS</a></td>
        </tr>
        </table>
        </center>
        </div>
  
<script>switchClass("#death_knight_blood");</script>
</body>
</html>
FOOTER;
    }
}
