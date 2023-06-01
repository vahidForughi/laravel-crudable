<?php

namespace Generaltools\Crudable\Classes\Chain;


class Chain
{

    protected array $handlers = [];


    function __construct($handlers)
    {
        $this->setHandlers($handlers);
    }


    function setHandlers($handlers)
    {
        $this->handlers = [];
        $prevKey = null;
        foreach($handlers as $key => $handler)
        {
            $this->handlers[$key] = new $handler($key);
            if ($prevKey)
                $this->handlers[$prevKey]->setNext($this->handlers[$key]);
            
            $prevKey = $key;
        }
    }

    
    public function handle($request)
    {
        if (!empty($this->handlers))
            $this->handleFrom(array_key_first($this->handlers), $request);
    }
    
    
    public function handleFrom($name, $request)
    {
        if (isset($this->handlers[$name]))
            $this->handlers[$name]->handle($request);
    }

}