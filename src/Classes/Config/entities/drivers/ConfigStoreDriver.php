<?php

namespace Generaltools\Crudable\Classes\Config\entities\drivers;

use Generaltools\Crudable\Utils\Names;

class ConfigStoreDriver implements StoreDriver {

    function __construct() {}

    private function entitiesStoreFile() {
        return config('crudable.store.config.file');
    }

    private function entitiesStoreLoc() {
        return $this->entitiesStoreFile();
    }

    private function constantsStoreLoc() {
        return $this->entitiesStoreFile().'.constants';
    }


    public function all() {
        return config($this->entitiesStoreLoc());
    }
    
    
    public function keys() {
        return array_keys($this->all());
    }
    
    
    public function find($key) {
        foreach (config($this->entitiesStoreLoc()) as $prop => $entities) {
            if ($prop !== "constants" && isset($entities[Names::entityName($key)])) {
                return $entities[Names::entityName($key)];
            }
        }
        return null;
        // return config($this->entitiesStoreLoc().'.'.Names::entityName($key));
    }
    
    
    public function constants() {
        return config($this->constantsStoreLoc());
    }


    public function constant($key) {
        return config($this->constantsStoreLoc().'.'.$key);
    }

}