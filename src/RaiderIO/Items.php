<?php

namespace RaiderIO;

use RaiderIO\Item;

class Items
{
    private static int $_count = 0;
    private static array $_items = array();
    private static array $_by_id = array();
    //private static array $_by_name = array();

    public static function consumeRaw($rawItem): ?Essence
    {
        if (! array_key_exists('id', $rawItem)) {
            return null;
        }

        $id = intval($item['id']);
        $byId = self::getById($id);

        if ($byId instanceof Essence) {
            return $byId;
        }

        var_dump($rawItem);
        exit();

        $essence = new Item();
        $essence->setId($id);
        $essence->setName($item['power']['essence']['name']);

        $offset = self::$_count++;

        self::$_items[$offset] = $essence;
        self::$_by_id[$id] = $offset;

        return self::$_items[$offset];
    }

    public static function getById(int $id): ?Essence
    {
        if (array_key_exists($id, self::$_by_id)) {
            $offset = self::$_by_id[$id];
            return self::$_items[$offset];
        }
        return null;
    }
}
