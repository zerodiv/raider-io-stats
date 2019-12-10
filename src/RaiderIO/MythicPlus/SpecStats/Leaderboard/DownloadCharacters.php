<?php

namespace RaiderIO\MythicPlus\SpecStats\Leaderboard;

use RaiderIO\MythicPlus\SpecStats\Leaderboard\Base;
use RaiderIO\PageDownloader;

class DownloadCharacters extends Base
{
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

            $id = intval($character['id']);
            $persona_id = intval($character['persona_id']);
            $path = $character['path'];
        
            if ($this->downloadCharacter($id, $persona_id, $path) === true) {
                $sleepAmt = mt_rand(1, 30);
                echo "sleeping ($sleepAmt)...\n";
                sleep($sleepAmt);
            }
        }
    }

    public function download(): bool
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

        return true;
    }

    public function downloadCharacter(int $id, int $persona_id, string $path): bool
    {

        // https://raider.io/api/characters/us/sargeras/Mixeleina?season=season-bfa-3&tier=24
        // https://raider.io/characters/us/whisperwind/Emeeana#season=season-bfa-3
        $url = sprintf(
            'https://raider.io/api%s#season=%s',
            $path,
            $this->getSeason()
        );

        var_dump($url);

        $tmpDir = $this->getTmpDir();
        $tmpDir .= DIRECTORY_SEPARATOR . 'characters';
        $tmpDir .= DIRECTORY_SEPARATOR . ($id % 10000);
        $tmpDir .= DIRECTORY_SEPARATOR . ($persona_id % 10000);
        
        var_dump($tmpDir);

        if (! is_dir($tmpDir)) {
            mkdir($tmpDir, 0755, true);
        }

        $rootFile = $tmpDir . DIRECTORY_SEPARATOR . $id . '-' . $persona_id;

        $statusFile = $rootFile . '.status';
        $contentFile = $rootFile . '.json';

        $pdl = new PageDownloader($url, $statusFile, $contentFile);

        if ($pdl->needsDownload() !== true) {
            echo "  does not need download\n";
            return false;
        }

        echo "  downloading\n";
        return $pdl->downloadPage();
    }


    public function parseJsonFile(string $file)
    {
        $contents = file_get_contents($file);
        return json_decode($contents, true);
    }
}
