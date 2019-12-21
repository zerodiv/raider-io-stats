<?php

namespace RaiderIO;

use RaiderIO\Essence;

class Essences
{
    private static int $_essenceCount = 0;
    private static array $_essences = array();
    private static array $_by_id = array();
    //private static array $_by_name = array();

    public static function consumeRaw($rawEssence): ?Essence
    {
        if (! array_key_exists('id', $rawEssence)) {
            return null;
        }

        $id = intval($rawEssence['id']);
        $byId = self::getById($id);

        if ($byId instanceof Essence) {
            return $byId;
        }

        $essence = new Essence();
        $essence->setId($id);
        $essence->setName($rawEssence['power']['essence']['name']);

        $offset = self::$_essenceCount++;

        self::$_essences[$offset] = $essence;
        self::$_by_id[$id] = $offset;

        return self::$_essences[$offset];
    }

    public static function getById(int $id): ?Essence
    {
        if (array_key_exists($id, self::$_by_id)) {
            $offset = self::$_by_id[$id];
            return self::$_essences[$offset];
        }
        return null;
    }
}
