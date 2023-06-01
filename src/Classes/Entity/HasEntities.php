<?php

namespace Generaltools\Crudable\Classes\Entity;

use Generaltools\Crudable\Classes\Entity\Entity;
use Generaltools\Crudable\Classes\Names;
use Generaltools\Crudable\Classes\Crudable;

trait HasEntities
{
    static private array $entities = [];


    static public function entities() {
        return self::$entities;
    }


    static public function entity($name) {
        $entityName = Names::entityName($name);
        if (!isset(self::$entities[$entityName])) {
            $schema = Crudable::config()->entities($entityName);
            self::$entities[$entityName] = new Entity($entityName, $schema);
            self::$entities[$entityName]->init($schema);
        }

        return self::$entities[$entityName];
    }

}
