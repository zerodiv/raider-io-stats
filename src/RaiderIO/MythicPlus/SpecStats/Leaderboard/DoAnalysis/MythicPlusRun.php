<?php

namespace RaiderIO\MythicPlus\SpecStats\Leaderboard\DoAnalysis;

class MythicPlusRun
{
    private int $_zoneId;
    private int $_keystoneRunId;
    private int $_mythicLevel;
    private int $_clearTimeMs;
    private float $_score;

    public function __construct()
    {
        $this->_zoneId = 0;
        $this->_keystoneRunId = 0;
        $this->_mythicLevel = 0;
        $this->_clearTimeMs = 0;
        $this->_score = 0.0;
    }

    public function getZoneId(): int
    {
        return $this->_zoneId;
    }

    public function getKeystoneRunId(): int
    {
        return $this->_keystoneRunId;
    }

    public function getMythicLevel(): int
    {
        return $this->_mythicLevel;
    }

    public function getClearTimeMs(): int
    {
        return $this->_clearTimeMs;
    }

    public function getScore(): float
    {
        return $this->_score;
    }

    public function parseChildTree($stack): bool
    {
        if (array_key_exists('zoneId', $stack)) {
            $this->_zoneId = intval($stack['zoneId']);
        }
        
        if (array_key_exists('keystoneRunId', $stack)) {
            $this->_keystoneRunId = intval($stack['keystoneRunId']);
        }

        if (array_key_exists('mythicLevel', $stack)) {
            $this->_mythicLevel = intval($stack['mythicLevel']);
        }

        if (array_key_exists('clearTimeMs', $stack)) {
            $this->_clearTimeMs = intval($stack['clearTimeMs']);
        }

        if (array_key_exists('score', $stack)) {
            $this->_score = floatval($stack['score']);
        }

        return true;
    }
}
