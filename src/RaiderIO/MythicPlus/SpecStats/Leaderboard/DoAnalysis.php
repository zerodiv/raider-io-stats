<?php

namespace RaiderIO\MythicPlus\SpecStats\Leaderboard;

use RaiderIO\MythicPlus\SpecStats\Leaderboard\Base;
use RaiderIO\MythicPlus\SpecStats\Leaderboard\DoAnalysis\ItemStats;
use RaiderIO\MythicPlus\SpecStats\Leaderboard\DoAnalysis\MythicPlusScores;
use RaiderIO\MythicPlus\SpecStats\Leaderboard\DoAnalysis\NeckTraitStats;
use RaiderIO\MythicPlus\SpecStats\Leaderboard\DoAnalysis\TalentStats;
use RaiderIO\CharacterClass;
use RaiderIO\MythicPlus\Ranges;

class DoAnalysis extends Base
{
    private int $_possible;
    private int $_characters;
    private array $_unavailable;
    
    private ItemStats $_itemStats;
    private MythicPlusScores $_mythicPlusScores;
    private NeckTraitStats $_neckTraitStrats;
    private TalentStats $_talentStats;

    public function __construct(string $season, string $region, string $class, string $spec)
    {
        parent::__construct($season, $region, $class, $spec);

        $this->_possible = 0;
        $this->_characters = 0;
        // reason => int
        $this->_unavailable = array();

        $this->_itemStats = new ItemStats();
        $this->_mythicPlusScores = new MythicPlusScores();
        $this->_neckTraitStrats = new NeckTraitStats();
        $this->_talentStats = new TalentStats();
    }

    public function getPossibleCount(): int
    {
        return $this->_possible;
    }
    
    public function getCharacterCount(): int
    {
        return $this->_characters;
    }

    public function getUnavailable(): array
    {
        return $this->_unavailable;
    }
    
    public function getUnavailableCount(): int
    {
        $count = 0;
        foreach ($this->_unavailable as $reason => $cnt) {
            $count += $cnt;
        }
        return $count;
    }

    public function addUnavailable(string $reason): bool
    {
        if (! array_key_exists($reason, $this->_unavailable)) {
            $this->_unavailable[$reason] = 0;
        }
        $this->_unavailable[$reason]++;
        return true;
    }

    public function getItemStats(): ItemStats
    {
        return $this->_itemStats;
    }
    
    public function getTalentStats(): TalentStats
    {
        return $this->_talentStats;
    }

    public function getMythicPlusStats(): MythicPlusScores
    {
        return $this->_mythicPlusScores;
    }

    public function getNeckTraitStats(): NeckTraitStats
    {
        return $this->_neckTraitStrats;
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

        // Item stats are special in that there can be -alot- of them
        // go ahead and trim it down to the top list as we don't want to
        // carrry that memory forwards.
        $this->getItemStats()->trimToTop();
        

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
                $this->addUnavailable('parseCharacterFailed');
            }
        }
    }

    public function parseCharacter(int $id, int $persona_id): bool
    {
        $contentFile = $this->getCharacterContentFile($id, $persona_id);

        //var_dump($contentFile);

        if (! is_file($contentFile)) {
            // echo "  contentFile=$contentFile - unavailable\n";
            $this->addUnavailable('fileNotAvailable');
            return false;
        }

        // load the file up and parse it.
        $contents = file_get_contents($contentFile);

        $js = json_decode($contents, true);

        if (! is_array($js)) {
            echo "  failed to parse contentFile=$contentFile\n";
            $this->addUnavailable('invalidJson');
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
                $this->addUnavailable('badHttpDownload');
                return false;
            }
        }

        if (array_key_exists('characterDetails', $js) !== true) {
            echo "  failed to find characterDetails contentFile=$contentFile\n";
            $this->addUnavailable('noCharacterDetails');
            return false;
        }

        return $this->handleCharacterDetails($contentFile, $js['characterDetails']);
    }

    public function handleCharacterDetails(string $contentFile, array $details): bool
    {
        if (array_key_exists('character', $details) !== true) {
            echo "  failed to find character contentFile=$contentFile\n";
            $this->addUnavailable('noCharacter');
            return false;
        }

        $character = $details['character'];

        // verify we are processing the right class.
        if (array_key_exists('class', $character)) {
            $className = $character['class']['name'];
            $className = strtolower($className);
            $className = str_replace(' ', '-', $className);
            if ($className != $this->getClass()) {
                // wrong class.
                //var_dump($className);
                $this->addUnavailable('wrongClass_' . $this->getClass() . '_had_' . $className);
                return false;
            }
        }

        // verify we are processing the right spec.
        if (array_key_exists('spec', $character)) {
            $specName = $character['spec']['name'];
            $specName = strtolower($specName);
            $specName = str_replace(' ', '-', $specName);
            if ($specName != $this->getSpec()) {
                // wrong spec
                //var_dump($specName);
                $this->addUnavailable('wrongSpec_' . $this->getSpec() . '_had_' . $specName);
                return false;
            }
        }

        if (array_key_exists('talentsDetails', $character) !== true) {
            echo "  failed to find talentsDetails contentFile=$contentFile\n";
            $this->addUnavailable('noTalentDetails');
            return false;
        }

        if (array_key_exists('mythicPlusScores', $details) !== true) {
            echo "  failed to find mythicPlusScores contentFile=$contentFile\n";
            $this->addUnavailable('noMythicPlusSores');
            return false;
        }

        $highestRun = $this->handleMythicPlusScores(
            $this->getClass(),
            $this->getSpec(),
            $details['mythicPlusScores']
        );
        
        if ($highestRun === 0) {
            //echo "  highestMplusWasZero contentFile=$contentFile\n";
            $this->addUnavailable('highestMplusWasZero');
            return false;
        }
        
        $range = Ranges::getRangeForLevel($highestRun);

        // var_dump($range);

        if ($this->handleTalentDetails($range, $character['talentsDetails']) !== true) {
            $this->addUnavailable('handleTalentDetailsFailed');
            return false;
        }

        if (array_key_exists('itemDetails', $details)) {
            $itemDetails = $details['itemDetails'];

            // extract the nested array
            // items.neck.heart_of_azeroth.essences[]
            if (array_key_exists('items', $itemDetails)) {
                $items = $itemDetails['items'];

                // allow the item handler to process all of the items.

                $this->_itemStats->handle($contentFile, $this->getClass(), $this->getSpec(), $items);

                if (array_key_exists('neck', $items)) {
                    $neck = $items['neck'];

                    $this->_neckTraitStrats->handle($neck);
                }
            }
        }

        return true;
    }

    public function handleMythicPlusScores(string $class, string $spec, array $mythicPlusScores): int
    {
        return $this->_mythicPlusScores->processMythicPlusStack($class, $spec, $mythicPlusScores);
    }

    public function handleTalentDetails(string $range, array $talentDetails): bool
    {
        return $this->_talentStats->processTalentStack(
            $this->getClass(),
            $this->getSpec(),
            $range,
            $talentDetails
        );
    }
}
