<?php

namespace Generaltools\Crudable\Classes\traits;

use Generaltools\Crudable\Classes\Config\ConfigManager;

trait HasConfig
{

    static private $config;


    private function initConfig()
    {
        self::$config = new ConfigManager();
    }


    static function config()
    {
        return self::$config;
    }

}
