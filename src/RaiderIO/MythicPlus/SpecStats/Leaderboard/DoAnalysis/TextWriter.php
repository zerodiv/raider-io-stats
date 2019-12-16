<?php

namespace RaiderIO\MythicPlus\SpecStats\Leaderboard\DoAnalysis;

use RaiderIO\CharacterClass;
use RaiderIO\MythicPlus\SpecStats\Leaderboard\DoAnalysis;

class TextWriter
{
    public function writeAnalysis(DoAnalysis $ana): bool
    {
        echo sprintf(
            "season=%s region=%s class=%s spec=%s\n",
            $ana->getSeason(),
            $ana->getRegion(),
            $ana->getClass(),
            $ana->getSpec()
        );

        echo sprintf(
            "  Leaderboard dataset characters=%d (%d%%) unavailable=%d (%d%%) possible=%d\n",
            $ana->getCharacterCount(),
            $ana->calculatePct($ana->getCharacterCount(), $ana->getPossibleCount()),
            $ana->getUnavailableCount(),
            $ana->calculatePct($ana->getUnavailableCount(), $ana->getPossibleCount()),
            $ana->getPossibleCount()
        );
        

        $badSpecCount = $ana->getTalentStats()->getBadSpecCount();
        $talentCount = $ana->getTalentStats()->getCharacterCount();

        echo sprintf(
            "  Talents distribution badSpecs=%d totalSpecs=%d (%0d%%) - [Goal is 0 for bad specs]\n",
            $badSpecCount,
            $talentCount,
            $ana->calculatePct($badSpecCount, $talentCount)
        );
       
        $talentStats = $ana->getTalentStats()->getTalentStats($ana->getClass(), $ana->getSpec());
        $talents = CharacterClass::getTalentsForClassSpec($ana->getClass(), $ana->getSpec());

        $col = 0;
        $row = '';
        foreach ($talents as $spellId) {
            $col++;

            if ($row != '') {
                $row .= ' | ';
            }


            $row .= sprintf(
                '%25s: %-10d (%3d%%)',
                CharacterClass::resolveTalentToName($spellId),
                $talentStats[$spellId],
                $ana->calculatePct($talentStats[$spellId], $talentCount)
            );

            if ($col == 3) {
                echo $row . "\n";
                $row = '';
                $col = 0;
            }
        }
        
        $runCount =  $ana->getMythicPlusStats()->getRunCount();
        $calcCount = $ana->getMythicPlusStats()->getCalcCount();
        
        echo sprintf(
            "  Total mythic runs for this spec captured runs=%d calcCount=%d\n",
            $runCount,
            $calcCount
        );

        $runsByLevelBucketed = $ana->getMythicPlusStats()->getRunsByLevelBucketed();
        
        foreach ($runsByLevelBucketed as $levelRange => $ranAmount) {
            echo sprintf(
                "  level %6s : %d (%d%%)\n",
                $levelRange,
                $ranAmount,
                $ana->calculatePct($ranAmount, $runCount)
            );
        }

        return true;
    }
}
