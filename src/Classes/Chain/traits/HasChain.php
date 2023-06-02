<?php

namespace Generaltools\Crudable\Classes\Chain\traits;


use Generaltools\Crudable\Classes\Chain\Chain;

trait HasChain
{

    private Chain $chain;

    private array $handlers = [];


    function setChain($handlers)
    {
        $this->chain = new Chain($handlers);
    }


    function handle($request)
    {
        $this->chain->handle($request);
    }


    function handlers()
    {
        return array_keys($this->handlers);
    }

}
