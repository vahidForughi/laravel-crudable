<?php

namespace Generaltools\Crudable\Classes\Entity;

use Generaltools\Crudable\Classes\Config;

class Entities
{
    static public array $entities = [];

    static public function getEntity($name) {
        if (!isset(self::$entities[$name]))
            self::$entities[$name] = new Entity($name, self::getEntitySchema($name));

        return self::$entities[$name];
    }

    static function getEntitySchema($name) {
        return Config::getEntitySchema($name);
    }
}

