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
        
        $unavailable = $ana->getUnavailable();

        arsort($unavailable, SORT_NUMERIC);

        echo "  Unavailable breakdown:\n";
        foreach ($unavailable as $reason => $cnt) {
            echo sprintf(
                "  %30s: %d\n",
                $reason,
                $cnt
            );
        }

        $range = '10-14';

        $specBadCount = $ana->getTalentStats()->getBadSpecCount($range);
        $specCount = $ana->getTalentStats()->getCharacterCount($range);
        $specTotal = $ana->getTalentStats()->getPossibleCharacterCount($range);

        echo sprintf(
            "  Range (%s) Talents distribution totalSpecs=%d (%d%%) badSpecs=%d (%d%%) - [Goal is 0 for bad specs]\n",
            $range,
            $specCount,
            $ana->calculatePct($specCount, $specTotal),
            $specBadCount,
            $ana->calculatePct($specBadCount, $specTotal)
        );
       
        $talentStats = $ana->getTalentStats()->getTalentStats($ana->getClass(), $ana->getSpec(), $range);

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
                $ana->calculatePct($talentStats[$spellId], $specCount)
            );

            if ($col == 3) {
                echo $row . "\n";
                $row = '';
                $col = 0;
            }
        }
        
        $runnerCount =  $ana->getMythicPlusStats()->getRunnerCount();
        
        echo sprintf(
            "  Total mythic runs for this spec captured runnerCount=%d\n",
            $runnerCount
        );

        $runsByLevelBucketed = $ana->getMythicPlusStats()->getRunnersByLevelBucketed();
        
        foreach ($runsByLevelBucketed as $levelRange => $runnersCount) {
            echo sprintf(
                "  level %6s : %d (%d%%)\n",
                $levelRange,
                $runnersCount,
                $ana->calculatePct($runnersCount, $runnerCount)
            );
        }

        return true;
    }
}
