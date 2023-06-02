<?php

namespace Generaltools\Crudable\Classes\Response\traits;


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
