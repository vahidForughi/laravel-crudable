<?php

namespace Generaltools\Crudable\Classes\traits;


trait HasResponse
{

    protected $response = [];

    
    function response()
    {
        return $this->response;
    }

    
    function setResponse($response)
    {
        $this->response = $response;
    }

}
