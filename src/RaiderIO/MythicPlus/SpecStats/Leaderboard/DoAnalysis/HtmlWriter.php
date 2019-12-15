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
        $characterNav = '<h1>Character and Talent Spec Stats</h1>';

        $characterNav = '<table border="1" width="100%">';

        foreach (CharacterClass::getActiveClassesAndSpecs() as $class => $specs) {
            $characterNav .= '<td><h4>' . ucwords(str_replace('-', ' ', $class)) . '</h4></td>';
        }
        $characterNav .= '</tr>';

        foreach (CharacterClass::getActiveClassesAndSpecs() as $class => $specs) {
            $characterNav .= '<td><ul>';
            foreach ($specs as $spec) {
                $characterNav .= '<li><h5><a href="#' . $class . '_' . $spec . '">' . $spec . '</a></h5></li>';
            }
            $characterNav .= '</ul></td>';
        }

        $characterNav .= '</table>';
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

        $outputBuffer .= '<div id=<"%s_%s">';
        
        $outputBuffer .= sprintf(
            '<a name="%s_%s"><h3>%s: %s</h3></a>',
            $class,
            $spec,
            ucwords(str_replace('-', ' ', $class)),
            $spec
        );

        $outputBuffer .= '<center><table border="0" width="100%">';
        
        $outputBuffer .= '<tr>';

        $runCount =  $ana->getMythicPlusStats()->getRunCount();
        $runsByLevelBucketed = $ana->getMythicPlusStats()->getRunsByLevelBucketed();
        
        $outputBuffer .= '<td style="border:0" width="50%">';
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

        $outputBuffer .= '<td style="border: 0" width="50%">';
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

        $outputBuffer .= '<h4>Talent choices for all characters Surveyed:</h4>';

        $outputBuffer .= '<center><table border="1" width="100%">';

        $col = 0;
        $row = array();
        $talentMarkup = array();
        foreach ($talents as $spellId) {
            $col++;

            $row[] = $spellId;

            if ($col == 3) {
                var_dump($row);

                $rowMap = array();
                foreach ($row as $spellId) {
                    $rowMap[$spellId] = $talentStats[$spellId];
                }
                var_dump($rowMap);

                // now we have a talent row, sort it
                arsort($rowMap, SORT_NUMERIC);
                
                $offset = 0;
                foreach ($rowMap as $spellId => $count) {
                    $offset++;
                    $talentMarkup[$spellId] = $offset;
                }

                var_dump($talentMarkup);
                
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
                '<td class="%s"><b>%s</b></td><td class="%s">%-10d (%3d%%)</td>',
                $talentCss,
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

        $outputBuffer .= '</div>';

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
<link href="http://thomasf.github.io/solarized-css/solarized-dark.min.css" rel="stylesheet"></link>
<script>var whTooltips = {colorLinks: true, iconizeLinks: true, renameLinks: true};</script>
<script src="https://wow.zamimg.com/widgets/power.js"></script>
<style>
td, th {
    border: 1px solid white;   
}
.goodTalent {
    background-color: #859900;
    color: #000000;
}
.marginalTalent {
    background-color: #b58900;
    color: #000000;
}
.badTalent {
    background-color: #d33682;
    color: #000000;
}
</style>
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
        <h5>Credits:</h5>  
        <ul>
        <li><a href="https://raider.io/">Raider IO</a></li>
        <li><a href="http://www.github.com">Hosted on GitHub Pages</a></li>
        </ul>
        </div>
  
</body>
</html>
FOOTER;
    }
}
