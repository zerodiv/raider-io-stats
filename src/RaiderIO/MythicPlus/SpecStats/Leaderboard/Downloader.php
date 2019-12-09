<?php declare (strict_types = 1);

namespace RaiderIO\MythicPlus\SpecStats\Leaderboard;

use RaiderIO\MythicPlus\SpecStats\Leaderboard\Base;

use \Exception;

class Downloader extends Base
{
    const NUMBER_OF_PAGES = 100;  

    public function download(): bool
    {

        $tmpDir = $this->getTmpDir();

        for ($p = 0; $p < self::NUMBER_OF_PAGES; $p++) {

            $pageFileRoot = $tmpDir . DIRECTORY_SEPARATOR . $p;
            $pageFile = $pageFileRoot . '.json';
            $pageStatusFile = $pageFileRoot . '.status';

            $needsDownload = false;
            if ( is_file($pageStatusFile) ) {

            } else {
                $needsDownload = true;
            }

            if ( $needsDownload === false ) {
                continue;
            }

            // Do a single page download.
            $this->downloadPage($p, $pageFile, $pageStatusFile);

            echo "downloaded page=$p\n";

            // sleep for a bit, don't break raider.io
            $sleepAmt = mt_rand(1, 60);
            echo "sleeping($sleepAmt)...\n";
            sleep($sleepAmt);

        }

        return true;

    }

    public function downloadPage(int $pageId, string $pageFile, string $pageStatusFile) {
        // 'https://raider.io/mythic-plus-spec-rankings/season-bfa-3/us/mage/frost/'
        //  https://raider.io/api/mythic-plus/rankings/specs?region=us&season=season-bfa-3&class=mage&spec=frost&page=2
        $url = sprintf(
            'https://raider.io/api/mythic-plus/rankings/specs?region=%s&season=%s&class=%s&spec=%s&page=%d',
            $this->getRegion(),
            $this->getSeason(),
            $this->getClass(),
            $this->getSpec(),
            $pageId
        );

        echo "url=$url\n";
        $ch = curl_init();

        curl_setopt($ch, 
            CURLOPT_USERAGENT, 
            'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3983.2 Safari/537.36'
        );
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        //curl_setopt($ch, CURLOPT_VERBOSE , true);
        $urlContents = curl_exec($ch);

        // var_dump($urlContents);

        curl_close($ch);

        file_put_contents($pageFile, $urlContents);
        file_put_contents($pageStatusFile, $pageStatusFile);
        
    }



}
