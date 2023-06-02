<?php

namespace Generaltools\Crudable\Classes\Entity\traits;

use Generaltools\Crudable\Classes\Crudable;
use Illuminate\Support\Facades\Gate;

trait HasPolicies
{
    
    private function initPolicies()
    {
        foreach (Crudable::config()->entitiesKeys() as $entity) {
            Gate::define($entity.'update-post', function () {
                return request()->user()->hasPermission();
            });
        }
    }

}
