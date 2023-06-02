<?php

namespace Generaltools\Crudable\Classes\Entity\traits;

use Illuminate\Support\Facades\Gate;

trait HasPolicies
{
    
    private function initPolicies()
    {
        foreach (self::config()->entitiesKeys() as $entity) {
            Gate::define($entity.'update-post', function () {
                return request()->user()->hasPermission();
            });
        }
    }

}
