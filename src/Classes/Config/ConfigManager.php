<?php

namespace Generaltools\Crudable\Classes\Config;

use Generaltools\Crudable\Classes\Config\configurations\ConfigDriverInterface;
use Generaltools\Crudable\Classes\Config\configurations\ArrayDriver;

class ConfigManager extends Manager {

    public function createArrayDriver(): ConfigDriverInterface {
        return new ArrayDriver($this->getDefaultConfiguration());
    }


    public function getDefaultDriver(): string {
        return config('crudable.crudable.default');
    }


    public function configurations(string $name = null): array {
        return config('crudable.crudable.configurations');
    }


    public function getConfiguration(string $name) {
        return config('crudable.crudable.configurations.'.$name);
    }


    public function getDefaultConfiguration(): array {
        return $this->getConfiguration($this->getDefaultDriver());
    }


    // static function getEntitySchema($name) {
    //     return config('entities.entities.'.Names::entityName($name));
    //     // return json_decode(file_get_contents(__dir__ . '\crudable\entities\\' . $name . '.json'), true);
    // }


    function getPath($name)
    {
        return config('crudable.crudable.path.'.$name);
    }


    function getModelsPath($name)
    {
        return $this->entities($name)->getModelClass();
        // return self::getPath('models');
    }

}
