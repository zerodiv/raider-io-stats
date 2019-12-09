<?php 

namespace RaiderIO\MythicPlus;

class Seasons {

  private static $_seasons = array(
    'season-bfa-3' => true
  );

  private static $_activeSeasons = array(
    'season-bfa-3'
  );

  public static function getActiveSeasons() {
    return self::$_activeSeasons;
  }

  public static function isValidSeason($season) {
      return array_key_exists($season, self::$_seasons);
  }

}
