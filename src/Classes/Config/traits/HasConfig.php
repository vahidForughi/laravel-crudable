<?php

namespace Generaltools\Crudable\Classes\Config\traits;

use Generaltools\Crudable\Classes\Config\Config;

trait HasConfig
{

    static private $config;

    
    private function initConfig()
    {
        self::$config = new Config;
    }

    
    static function config()
    {
        return self::$config;
    }

}
