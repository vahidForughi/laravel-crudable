<?php

namespace Generaltools\Crudable\Classes\Entity;


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
