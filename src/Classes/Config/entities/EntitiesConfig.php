<?php

namespace Generaltools\Crudable\Classes\Config\entities;

use Generaltools\Crudable\Classes\Config\entities\drivers\StoreDriver;
use Illuminate\Support\Str;

class EntitiesConfig implements StoreDriver {
    private $storeDriver;
    
    public function __construct() {
        $this->storeDriver = $this->newStoreDriver();
    }
    
    private function newStoreDriver(): StoreDriver {
        $driverClass = __NAMESPACE__.'\\drivers\\'.Str::studly(config('crudable.driver').'StoreDriver');
        return new $driverClass();
    }

    public function all() {
        return $this->storeDriver->all();
    }

    public function keys() {
        return $this->storeDriver->keys();
    }

    public function find(string $key) {
        return $this->storeDriver->find($key);
    }

    public function constants() {
        return $this->storeDriver->constants();
    }

    public function constant($key) {
        return $this->storeDriver->constant($key);
    }
}
