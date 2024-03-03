<?php

namespace Generaltools\Crudable\Classes\Entity;

use Generaltools\Crudable\Classes\Entity\traits\HasModelSchema;
use Generaltools\Crudable\Classes\Entity\traits\HasFields;
use Generaltools\Crudable\Classes\Entity\traits\HasRoutes;
use Generaltools\Crudable\Utils\Stub;

class Entity
{
    use HasModelSchema,
        HasFields,
        HasRoutes;


    public string $name = '';
    // public array $constants = [];


    function __construct($name) {
        $this->name = $name;
    }


    function init($schema): void {
        if ($schema)
            $this->parseSchemaProps($schema);
        $this->evalModel();
    }


    public function evalModel()
    {
//         if ($this->name == 'article'){
//    //         // dd($this);
//            $template = Stub::getView('model',[
//                "Entity" => $this
//            ]);
//            dd($template);
//        }
//        dd(Stub::getView('model', [
//            "Entity" => $this
//        ]));
        eval( Stub::getView('model', [
            "Entity" => $this
        ]));
    }


    // function __toString() {
    //     return json_decode( json_encode($this), true);
    // }

}

