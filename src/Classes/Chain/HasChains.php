<?php

namespace Generaltools\Crudable\Classes\Chain;


trait HasChains
{

    private array $chains = [];


    function addChain($name, $handlers)
    {
        $this->chains[$name] = new Chain($handlers);
    }


    function handleChain($name, $request)
    {
        $this->chains[$name]->handle($request);
    }


    function handle($request)
    {
        foreach($this->chains as $name => $chain)
            $this->handleChain($name, $request);
    }



}
