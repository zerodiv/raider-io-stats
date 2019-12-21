<?php

namespace RaiderIO\MythicPlus\SpecStats\Leaderboard\DoAnalysis;

use RaiderIO\HtmlDir;
use RaiderIO\CharacterClass;
use RaiderIO\MythicPlus\SpecStats\Leaderboard\DoAnalysis;
use RaiderIO\MythicPlus\SpecStats\Leaderboard\DoAnalysis\HtmlWriter\HtmlHeaderBlock;
use RaiderIO\MythicPlus\SpecStats\Leaderboard\DoAnalysis\HtmlWriter\HtmlFooterBlock;
use RaiderIO\MythicPlus\SpecStats\Leaderboard\DoAnalysis\HtmlWriter\HtmlByRoleLeaders;
use RaiderIO\MythicPlus\SpecStats\Leaderboard\DoAnalysis\HtmlWriter\HtmlCharacterNav;
use RaiderIO\MythicPlus\SpecStats\Leaderboard\DoAnalysis\HtmlWriter\HtmlSpecAnalysis;

class HtmlWriter
{
    private array $_analysisStack = array();

    public function addAnalysis(DoAnalysis $ana): bool
    {
        $this->_analysisStack[] = $ana;
        return true;
    }

    public function getAnalysisStack(): array
    {
        return $this->_analysisStack;
    }

    public function writeIndex()
    {
        $indexFile = HtmlDir::get() . '/index.html';

        echo "indexFile=$indexFile\n";
        $fh = fopen($indexFile, 'w');

        fwrite($fh, HtmlHeaderBlock::create($this, ''));
        fwrite($fh, HtmlCharacterNav::create($this));

        // --
        // Walk each spec for it's stats.
        // --
        foreach ($this->getAnalysisStack() as $ana) {
            fwrite($fh, HtmlSpecAnalysis::create($this, $ana));
            // $this->addClassSpecAnalysis($fh, $ana);
        }
        
        fwrite($fh, HtmlByRoleLeaders::create($this));

        fwrite($fh, HtmlFooterBlock::create($this, ''));
        fclose($fh);
    }

    public function addClassSpecAnalysis($fh, DoAnalysis $ana): bool
    {
        fwrite($fh, $outputBuffer);

        return true;
    }
}
