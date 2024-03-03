<?php

namespace Generaltools\Crudable\Classes\Config\configurations;

use Generaltools\Crudable\Utils\Convertor;
use Generaltools\Crudable\Utils\Names;

class ArrayDriver implements ConfigDriverInterface {


    protected string $dir;


    function __construct(array $options = []) {
        $this->dir = $options['dir'] ?? '';
    }


    public function entities(?string $name = null) {
        return $name ? $this->getEntity($name) :
                       $this->allEntities();
    }


    public function allEntities(bool $merge = true) {
        $entities = config('crudable.entities');

        if ($merge)
            $entities = Convertor::addonMerge(...$entities);

        return $entities;
    }


    public function entitiesKeys() {
        return array_keys($this->allEntities());
    }


    public function getEntity($key) {
        $entities = $this->allEntities();

        if (isset($entities[Names::entityName($key)]))
            return $entities[Names::entityName($key)];

        return null;
    }


    public function constants($key = null) {
        return $key ? $this->getConstant($key) :
                      $this->allConstants();
    }


    public function allConstants(bool $merge = true) {
        $constants = config('crudable.constants');

        if ($merge)
            $constants = Convertor::addonMerge(...$constants);

        return $constants;
    }


    public function getConstant($key) {
        $constants = $this->allConstants();

        if (isset($constants[$key]))
            return $constants[$key];

        return null;
    }

}
