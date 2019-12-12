<?php

namespace RaiderIO\MythicPlus\SpecStats\Leaderboard;

use RaiderIO\MythicPlus\SpecStats\Leaderboard\Base;
use RaiderIO\MythicPlus\SpecStats\Leaderboard\TalentStats;
use RaiderIO\CharacterClass;

class DoAnalysis extends Base
{
    private int $_possible;
    private int $_characters;
    private int $_unavailable;
    private TalentStats $_talentStats;

    public function __construct(string $season, string $region, string $class, string $spec)
    {
        parent::__construct($season, $region, $class, $spec);

        $this->_possible = 0;
        $this->_characters = 0;
        $this->_unavailable = 0;
        $this->_talentStats = new TalentStats();
    }

    public function crunchNumbers(): void
    {
        $tmpDir = $this->getTmpDir();

        $fds = scandir($tmpDir);

        foreach ($fds as $fd) {
            // we only care about the json files.
            if (! preg_match("/\.json$/", $fd)) {
                continue;
            }

            // crack open the json file and bring it local.
            $jsonFile = $tmpDir . DIRECTORY_SEPARATOR . $fd;

            // parse the file
            $js = $this->parseJsonFile($jsonFile);
            
            // walk it and download the individual characters
            $this->walkJsonStructure($js);
        }

        echo sprintf(
            "season=%s region=%s class=%s spec=%s\n",
            $this->getSeason(),
            $this->getRegion(),
            $this->getClass(),
            $this->getSpec()
        );

        echo sprintf(
            "  characters=%d (%d%%) unavailable=%d (%d%%) possible=%d\n",
            $this->_characters,
            $this->calculatePct($this->_characters, $this->_possible),
            $this->_unavailable,
            $this->calculatePct($this->_unavailable, $this->_possible),
            $this->_possible
        );
        
        $talentStats = $this->_talentStats->getTalentStats($this->getClass(), $this->getSpec());

        $talents = CharacterClass::getTalentsForClassSpec($this->getClass(), $this->getSpec());

        $talentCount = $this->_talentStats->getCharacterCount();
        echo "Talents distribution ($talentCount): \n";
        
        $col = 0;
        $row = '';
        foreach ($talents as $spellId) {
            $col++;

            if ($row != '') {
                $row .= ' | ';
            }


            $row .= sprintf(
                '%10d: %-10d (%3d%%)',
                $spellId,
                $talentStats[$spellId],
                $this->calculatePct($talentStats[$spellId], $talentCount)
            );

            if ($col == 3) {
                echo $row . "\n";
                $row = '';
                $col = 0;
            }
        }
        

        // var_dump($talentStats);

        // var_dump($this->_talentStats);
    }

    public function calculatePct(int $a, int $b): int
    {
        if ($b == 0) {
            return 0;
        }
        return intval(($a / $b) * 100);
    }

    public function parseJsonFile(string $file)
    {
        $contents = file_get_contents($file);
        return json_decode($contents, true);
    }

    public function walkJsonStructure($js)
    {
        // do a pass removing fields we don't care about.
        foreach ($js['rankings']['rankedCharacters'] as $ranked) {
            $id = null;
            $persona_id = null;
            $path = null;

            if (!array_key_exists('character', $ranked)) {
                continue;
            }

            $character = $ranked['character'];

            if (!array_key_exists('id', $character) ||
                !array_key_exists('persona_id', $character) ||
                !array_key_exists('path', $character)
                ) {
                continue;
            }

            // var_dump($character);

            $id = intval($character['id']);
            $persona_id = intval($character['persona_id']);
            $path = $character['path'];
        
            $this->_possible++;

            if ($this->parseCharacter($id, $persona_id) === true) {
                $this->_characters++;
            } else {
                $this->_unavailable++;
            }
        }
    }

    public function parseCharacter(int $id, int $persona_id): bool
    {
        $contentFile = $this->getCharacterContentFile($id, $persona_id);

        //var_dump($contentFile);

        if (! is_file($contentFile)) {
            // echo "  contentFile=$contentFile - unavailable\n";
            return false;
        }

        // load the file up and parse it.
        $contents = file_get_contents($contentFile);

        $js = json_decode($contents, true);

        if (! is_array($js)) {
            echo "  failed to parse contentFile=$contentFile\n";
            return false;
        }

        if (array_key_exists('statusCode', $js)) {
            $statusCode = intval($js['statusCode']);
            $statusFile = $this->getCharacterStatusFile($id, $persona_id);
            if ($statusCode == 400) {
                // it failed to download, please cleanup.
                if (is_file($statusFile)) {
                    unlink($statusFile);
                }
                if (is_file($contentFile)) {
                    unlink($contentFile);
                }
                echo "  invalid character download\n";
                return false;
            }
        }

        if (array_key_exists('characterDetails', $js) !== true) {
            echo "  failed to find characterDetails contentFile=$contentFile\n";
            return false;
        }

        return $this->handleCharacterDetails($contentFile, $js['characterDetails']);
    }

    public function handleCharacterDetails(string $contentFile, array $details): bool
    {
        if (array_key_exists('character', $details) !== true) {
            echo "  failed to find character contentFile=$contentFile\n";
            return false;
        }

        $character = $details['character'];

        // verify we are processing the right class.
        if (array_key_exists('class', $character)) {
            if (strtolower($character['class']['name']) != $this->getClass()) {
                // wrong class.
                return false;
            }
        }

        // verify we are processing the right spec.
        if (array_key_exists('spec', $character)) {
            if (strtolower($character['spec']['name']) != $this->getSpec()) {
                // wrong spec
                return false;
            }
        }

        if (array_key_exists('talentsDetails', $character) !== true) {
            echo "  failed to find talentsDetails contentFile=$contentFile\n";
            return false;
        }

        return $this->handleTalentDetails($character['talentsDetails']);
    }

    public function handleTalentDetails($talentDetails): bool
    {
        return $this->_talentStats->processTalentStack($this->getClass(), $this->getSpec(), $talentDetails);
    }
}
