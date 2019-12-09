<?php 

require_once './src/path.php';

use RaiderIO\MythicPlus\SpecStats\Leaderboard\DownloadCharacters;

$downloader = new DownloadCharacters();

if ( $downloader->download() === true ) {
   echo "All downloaded\n";
   exit(0);
} 

echo "Failed to download!\n";
exit(255);