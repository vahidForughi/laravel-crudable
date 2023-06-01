<?php

namespace Generaltools\Crudable\Classes\Chain;


interface Handler
{

    public function setNext(Handler $handler);

    public function handle($request);

}