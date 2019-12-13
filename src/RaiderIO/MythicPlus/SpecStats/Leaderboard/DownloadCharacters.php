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
                $this->doSleep('downloadedCharacter');
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
        if ($path == '') {
            return false;
        }
        
        // https://raider.io/api/characters/us/sargeras/Mixeleina?season=season-bfa-3&tier=24
        // https://raider.io/characters/us/whisperwind/Emeeana#season=season-bfa-3

        // By default the path isn't url safe, we need to encode it properly to support some of the utf-8 characters.
        // grab the char name off the end of the path.
        $pathBits = explode('/', $path);
        $characterName = array_pop($pathBits);

        // var_dump($path);

        $path = str_replace(
            $characterName,
            urlencode($characterName),
            $path
        );

        // var_dump($path);

        $url = sprintf(
            'https://raider.io/api%s#season=%s',
            $path,
            $this->getSeason()
        );

        //var_dump($url);

        $tmpDir = $this->getCharacterTmpDir($id, $persona_id);
        
        //var_dump($tmpDir);

        $rootFile = $tmpDir . DIRECTORY_SEPARATOR . $id . '-' . $persona_id;

        $statusFile = $rootFile . '.status';
        $contentFile = $rootFile . '.json';

        $pdl = new PageDownloader($url, $statusFile, $contentFile);

        if ($pdl->needsDownload() !== true) {
            // echo "  does not need download\n";
            return false;
        }

        echo "url=$url\n";
        echo "  downloading to=$contentFile\n";
        return $pdl->downloadPage();
    }


    public function parseJsonFile(string $file)
    {
        $contents = file_get_contents($file);
        return json_decode($contents, true);
    }
}
