<?php

namespace Generaltools\Crudable\Classes\Entity;


trait HasQuery
{

    protected array $resources = [];

    protected $query;


    private function initQuery()
    {
        $firstModelKey = array_key_first($this->resources); 
        $query = $this->loadModel($firstModelKey)->query();
        foreach ($this->resources as $key => $resource) {
            if ($firstModelKey != $key)
                $query = $query->firstOrFail()->{$key}();
            if ($resource)
                $query = $query->where($query->getModel()->getKeyName(),$resource);
//                $query = $query->findOrFail($resource);
        }
        $this->setQuery($query);
    }

    
    public function loadModel($name)
    {
        return new (self::entity($name)->getModelClass());
    }


    public function setQuery($query)
    {
        $this->query = $query;
    }


    public function query()
    {
        return $this->query;
    }

}
