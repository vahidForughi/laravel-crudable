<?php

namespace Generaltools\Crudable\Classes\Config\configurations;

interface ConfigDriverInterface {
    public function __construct(array $options = []);
    public function entities(?string $name = null);
    public function allEntities();
    public function getEntity($name);
    public function entitiesKeys();
    public function constants($key = null);
    public function allConstants();
    public function getConstant($key);
//    public function constantsKeys();
}
