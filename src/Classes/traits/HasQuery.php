<?php

namespace Generaltools\Crudable\Classes\traits;

use Generaltools\Crudable\Classes\Crudable;

trait HasQuery
{

    protected array $resources = [];

    protected $query;


    private function initQuery()
    {
        $firstModelKey = array_key_first($this->resources);
        if ($firstModelKey) {
            $query = $this->loadModel($firstModelKey)->query();
            foreach ($this->resources as $key => $resource) {
                if ($key != $firstModelKey)
                    $query = $query->firstOrFail()->{$key}();
                if ($resource)
                    $query = $query->where($key.'.'.$query->getModel()->getKeyName(),$resource);
            }
            $this->setQuery($query);
        }
    }

    
    public function loadModel($name)
    {
        return new (Crudable::entity($name)->getModelClass());
    }


    public function setQuery($query)
    {
        $this->query = $query;
    }


    public function query()
    {
        return $this->query;
    }


    function resources()
    {
        return $this->resources;
    }


    function setResources($resources)
    {
        $this->resources = $resources;
    }

}
