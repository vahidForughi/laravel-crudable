<?php

namespace Generaltools\Crudable\Classes\Config\entities\drivers;


interface StoreDriver {
    public function all();
    public function keys();
    public function find(string $key);
    public function constants();
    public function constant($key);
}