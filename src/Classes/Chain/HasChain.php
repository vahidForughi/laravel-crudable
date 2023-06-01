<?php

namespace Generaltools\Crudable\Classes\Chain;


trait HasChain
{

    private Chain $chain;


    function setChain($handlers)
    {
        $this->chain = new Chain($handlers);
    }


    function handle($request)
    {
        $this->chain->handle($request);
    }

}
