<?php

namespace Generaltools\Crudable\Classes\Chain;


class BaseHandler implements Handler
{

    private string $name;

    private ?Handler $next = null;


    function __construct($name)
    {
        $this->name = $name;
    }


    public function getName()
    {
        return $this->name;
    }
    
    
    public function setNext(Handler $handler)
    {
        $this->next = $handler;
    }
    

    public function handle($request)
    {
        if ($this->next)
            $this->next->handle($request);
    }

}