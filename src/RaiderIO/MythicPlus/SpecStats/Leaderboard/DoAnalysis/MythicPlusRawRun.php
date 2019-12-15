<?php

namespace RaiderIO\MythicPlus\SpecStats\Leaderboard\DoAnalysis;

class MythicPlusRawRun
{
    private int $_id;
    private int $_region_id;
    private int $_realm_id;
    private int $_keystone_team_id;
    private int $_zone_id;
    private string $_faction;
    private int $_mythic_level;
    private int $_clear_time_ms;
    private int $_par_time_ms;
    private int $_period;
    private string $_compleated_at;
    private int $_affix_0_id;
    private int $_affix_1_id;
    private int $_affix_2_id;
    private string $_created_at;
    private string $_updated_at;
    private string $_deleted_at;

    public function __construct()
    {
        $this->_id = 0;
        $this->_region_id = 0;
        $this->_realm_id = 0;
        $this->_keystone_team_id = 0;
        $this->_zone_id = 0;
        $this->_faction = '';
        $this->_mythic_level = 0;
        $this->_clear_time_ms = 0;
        $this->_par_time_ms = 0;
        $this->_period = 0;
        $this->_compleated_at = '';
        $this->_affix_0_id = 0;
        $this->_affix_1_id = 0;
        $this->_affix_2_id = 0;
        $this->_created_at = '';
        $this->_updated_at = '';
        $this->_deleted_at = '';
    }

    public function getId(): int
    {
        return $this->_id;
    }

    public function getRegionId(): int
    {
        return $this->_region_id;
    }

    public function getRealmId(): int
    {
        return $this->_realm_id;
    }

    public function getKeystoneTeamId(): int
    {
        return $this->_keystone_team_id;
    }

    public function getZoneId(): int
    {
        return $this->_zone_id;
    }

    public function getFaction(): string
    {
        return $this->_faction;
    }

    public function getMythicLevel(): int
    {
        return $this->_mythic_level;
    }

    public function getClearTimeMs(): int
    {
        return $this->_clear_time_ms;
    }

    public function getParTimeMs(): int
    {
        return $this->_par_time_ms;
    }

    public function getPeriod(): int
    {
        return $this->_period;
    }

    public function getCompletedAt(): string
    {
        return $this->_compleated_at;
    }

    public function getAffix0Id(): int
    {
        return $this->_affix_0_id;
    }

    public function getAffix1Id(): int
    {
        return $this->_affix_1_id;
    }

    public function getAffix2Id(): int
    {
        return $this->_affix_2_id;
    }

    public function getCreatedAt(): stirng
    {
        return $this->_created_at;
    }

    public function getUpdatedAt(): string
    {
        return $this->_updated_at;
    }

    public function getDeletedAt(): string
    {
        return $this->_deleted_at;
    }

    public function parseChildTree($stack): bool
    {
        if (array_key_exists('id', $stack) === true) {
            $this->_id = intval($stack['id']);
        }
        
        if (array_key_exists('region_id', $stack) === true) {
            $this->_region_id = intval($stack['region_id']);
        }

        if (array_key_exists('realm_id', $stack) === true) {
            $this->_realm_id = intval($stack['realm_id']);
        }

        if (array_key_exists('keystone_team_id', $stack) === true) {
            $this->_keystone_team_id = intval($stack['keystone_team_id']);
        }

        if (array_key_exists('zone_id', $stack) === true) {
            $this->_zone_id = intval($stack['zone_id']);
        }

        if (array_key_exists('faction', $stack) === true) {
            $this->_faction = strval($stack['faction']);
        }

        if (array_key_exists('mythic_level', $stack) === true) {
            $this->_mythic_level = intval($stack['mythic_level']);
        }

        if (array_key_exists('clear_time_ms', $stack) === true) {
            $this->_clear_time_ms = intval($stack['clear_time_ms']);
        }

        if (array_key_exists('par_time_ms', $stack) === true) {
            $this->_par_time_ms = intval($stack['par_time_ms']);
        }

        if (array_key_exists('period', $stack) === true) {
            $this->_period = intval($stack['period']);
        }

        if (array_key_exists('compleated_at', $stack) === true) {
            $this->_compleated_at = strval($stack['compleated_at']);
        }

        if (array_key_exists('affix_0_id', $stack) === true) {
            $this->_affix_0_id = intval($stack['affix_0_id']);
        }

        if (array_key_exists('affix_1_id', $stack) === true) {
            $this->_affix_1_id = intval($stack['affix_1_id']);
        }

        if (array_key_exists('affix_2_id', $stack) === true) {
            $this->_affix_2_id = intval($stack['affix_2_id']);
        }

        if (array_key_exists('created_at', $stack) === true) {
            $this->_created_at = strval($stack['created_at']);
        }

        if (array_key_exists('updated_at', $stack) === true) {
            $this->_updated_at = strval($stack['updated_at']);
        }

        if (array_key_exists('deleted_at', $stack) === true) {
            $this->_deleted_at = strval($stack['deleted_at']);
        }

        return true;
    }
}
