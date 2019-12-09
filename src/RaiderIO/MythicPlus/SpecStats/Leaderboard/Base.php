<?php

namespace RaiderIO\MythicPlus\SpecStats\Leaderboard;

use RaiderIO\CharacterClass;
use RaiderIO\MythicPlus\Seasons;
use RaiderIO\Regions;
use RaiderIO\TmpDir;
use \Exception;

class Base {
    private string $_season;
    private string $_region;
    private string $_class;
    private string $_spec;
    
    public function __construct(string $season, string $region, string $class, string $spec)
    {

        if (Regions::isValidRegion($region) !== true ) {
            throw new Exception('Invalid region=' . $region);
        }

        if (Seasons::isValidSeason($season) !== true) {
            throw new Exception('Invalid season=' . $season);
        }

        if (CharacterClass::isValidClassSpecCombo($class, $spec) !== true) {
            throw new Exception('Invalid class=' . $class . ' spec=' . $spec);
        }

        $this->_region = $region;
        $this->_season = $season;
        $this->_class = $class;
        $this->_spec = $spec;

    }

    public function getRegion(): string {
        return $this->_region;
    }

    public function getSeason(): string {
        return $this->_season;
    }

    public function getClass(): string {
        return $this->_class;
    }

    public function getSpec(): string {
        return $this->_spec;
    }

    public function getTmpDir(): string
    {
        $tmpDir = 
            TmpDir::get() . DIRECTORY_SEPARATOR .
            $this->_season . DIRECTORY_SEPARATOR .
            $this->_class . DIRECTORY_SEPARATOR .
            $this->_spec;

        if ( ! is_dir($tmpDir) ) {
            mkdir($tmpDir, 0755, true);
            if ( ! is_dir($tmpDir) ) {
                throw new Exception('Failed making tmpDir=' . $tmpDir);
            }            
        }
        return $tmpDir;
    }
    
}