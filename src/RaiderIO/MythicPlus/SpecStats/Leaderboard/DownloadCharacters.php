<?php 

namespace RaiderIO\MythicPlus\SpecStats\Leaderboard;

use RaiderIO\MythicPlus\SpecStats\Leaderboard\Base;

class DownloadCharacters extends Base {
    public function download() {

        $tmpDir = $this->getTmpDir();

        $fds = scandir($tmpDir);

        foreach ( $fds as $fd ) {
            // we only care about the json files.
            if (! preg_match("/\.json$/", $fd ) ) {
                continue;
            }

            // crack open the json file and bring it local. 
            $jsonFile = $tmpDir . DIRECTORY_SEPARATOR . $fd;

            $js = $this->parseJsonFile($jsonFile);

            // do a pass removing fields we don't care about.
            foreach ( $js['rankings']['rankedCharacters'] as $ranked ) {
               $id = null;
               $persona_id = null;
               $path = null;

               if ( array_key_exists('character', $ranked) ) {
                $character = $ranked['character'];

                if ( array_key_exists('id', $character) ) {
                    $id = intval($character['id']);
                }

                if ( array_key_exists('persona_id', $character) ) {
                    $persona_id = intval($character['persona_id']);                    
                }

                if (array_key_exists('path', $character) ) {
                    $path = $character['path'];
                }

               }

               if ( $id !== null && $persona_id !== null && $path !== null ) {

               }
                              
               // id 
               // persona_id
               var_dump($ranked);
               var_dump($ranked['character']['path']);
               exit();
            }
            var_dump($js);
            exit();

        }
    }

    public function downloadCharacter(int $id, int $persona_id, string $path) {

    }

    public function parseJsonFile(string $file) {
        $contents = file_get_contents($file);
        return json_decode($contents, true);
    }

}