<?php

namespace Generaltools\Crudable\Facades;

use \Generaltools\Crudable\Classes\Crudable as BaseCrudable;
use Illuminate\Support\Facades\Facade;

class Crudable extends Facade
{
    protected static function getFacadeAccessor() {
        return BaseCrudable::class;
    }
}
