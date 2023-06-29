<?php

namespace Generaltools\Crudable\Controllers\Actions\Crud;

use Generaltools\Crudable\Classes\Action\ActionInterface;
use Generaltools\Crudable\Facades\Crudable;
use Illuminate\Support\Str;

class Action implements ActionInterface
{
    private string $name;

    function __construct(string $name)
    {
        $this->name = $name;
    }

    public function getName() {
        return $this->name;
    }
    
    public function beforeAuthorize() {}
    public function authorize() {}
    public function afterAuthorize() {}

    public function beforeValidate() {}
    public function validate()
    {
        if (! empty(Crudable::resources()))
            request()->validate(Crudable::entity(array_key_last(Crudable::resources()))->getRules(Crudable::action()->getName()));
    }
    public function afterValidate() {}

    public function beforeModel() {}
    public function model() {}
    public function afterModel() {}

    public function beforeQuery() {}
    public function query() {}
    public function afterQuery() {}

    public function beforeAction() {}
    public function action() {}
    public function afterAction() {}

    public function beforeResponse() {}
    public function response() {}
    public function afterResponse() {}


}
