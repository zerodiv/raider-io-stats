<?php

namespace RaiderIO\MythicPlus\SpecStats\Leaderboard\DoAnalysis;

use RaiderIO\MythicPlus\SpecStats\Leaderboard\DoAnalysis\MythicPlusRawRun;

class MythicPlusScoreSlice
{
    private float $_score;
    private string $_scoreColor;
    private array $_runs;
    private array $_rawRuns;
    
    public function __construct()
    {
        $this->_score = 0.0;
        $this->_scoreColor = '';
        $this->_runs = array();
        $this->_rawRuns = array();
    }
    
    public function getRuns(): array
    {
        return $this->_runs;
    }

    public function getRawRuns(): array
    {
        return $this->_rawRuns;
    }

    public function parseChildTree($stack): bool
    {
        if (array_key_exists('score', $stack)) {
            $this->_score = floatval($stack['score']);
        }

        if (array_key_exists('scoreColor', $stack) === true) {
            $this->_scoreColor = strval($stack['scoreColor']);
        }

        if (array_key_exists('runs', $stack) && is_array($stack['runs'])) {
            $runs = $stack['runs'];

            foreach ($runs as $run) {
                $runObj = new MythicPlusRun();
                $runObj->parseChildTree($run);
                $this->_runs[] = $runObj;
            }
        }

        if (array_key_exists('rawRuns', $stack) && is_array($stack['rawRuns'])) {
            $rawRuns = $stack['rawRuns'];

            foreach ($rawRuns as $rawRun) {
                $rawRunObj = new MythicPlusRawRun();
                $rawRunObj->parseChildTree($rawRun);
                $this->_rawRuns[] = $rawRunObj;
            }
        }

        return true;
    }
}
