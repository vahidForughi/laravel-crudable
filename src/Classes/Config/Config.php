<?php

namespace Generaltools\Crudable\Classes\Config;

use Generaltools\Crudable\Classes\Config\entities\EntitiesConfig;
use Generaltools\Crudable\Classes\Entity\Entity;
use Illuminate\Support\Str;

class Config {

    private EntitiesConfig $entities;


    public function __construct() {
        $this->entities = new EntitiesConfig;
    }


    public function entities($name = null) {
        return $name ? $this->entities->find($name) : 
                       $this->entities->all();
    }


    public function entitiesKeys() {
        return $this->entities->keys();
    }

      
    public function constants($key = null) {
        return $key ? $this->entities->constants()
                    : $this->entities->constant($key);
    }
    

    // static function getEntitySchema($name) {
    //     return config('entities.entities.'.Names::entityName($name));
    //     // return json_decode(file_get_contents(__dir__ . '\crudable\entities\\' . $name . '.json'), true);
    // }


    function getPath($name)
    {
        return config('crudable.path.'.$name);
    }


    function getModelsPath($name)
    {
        return $this->entities($name)->getModelClass();
        // return self::getPath('models');
    }

}