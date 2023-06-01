<?php

namespace Generaltools\Crudable\Controllers\Crud;

use Generaltools\Crudable\Utils\Response;
use Generaltools\Crudable\Facades\Crudable;
// use Generaltools\Crudable\Controllers\Crud\IndexController;
use Illuminate\Support\Str;

class ActionController
{

    static public function beforeAuthorize() {}
    static public function authorize() {}
    static public function afterAuthorize() {}

    static public function beforeValidate() {}
    static public function validate()
    {
        request()->validate(Crudable::entity()->getRules(Crudable::action()));
    }
    static public function afterValidate() {}

    static public function beforeQuery() {}
    static public function Query() {}
    static public function afterQuery() {}

    static public function beforeAction() {}
    static public function Action() {}
    static public function afterAction() {}

    static public function beforeResponse() {}
    static public function Response() {}
    static public function afterResponse() {}

}
