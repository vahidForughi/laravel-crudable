<?php

namespace Generaltools\Crudable\Classes\Entity;


use Generaltools\Crudable\Classes\Crudable;
use Generaltools\Crudable\Classes\Config;

class Relation
{
    public $name;
    public $type;
    public $related;
    public $local_key;
    public $foreign_key;
    public $pivot_table;
    public $morphable_name;
    public $morphable_type;
    public $morphable_id;
    public $method_name;
    public $method_args;
    public $with = [];
    public $withPivot = [];
    public $withTimestamps = false;

    function __construct($schema) {
        $this->parseSchema($schema);
        $this->initMethod();
    }

    private function parseSchema($schema) {
        foreach ($schema as $key => $value) {
            $this->{$key} = $value;
        }
    }

    private function initMethod() {
        $method = $this->getMethod();
        $this->method_name = $method['name'];
        $this->method_args = $method['args'];
    }

    protected function getMethod() {
        $relationType = __NAMESPACE__ . '\\' . str_replace('-', '', ucwords($this->type, '-')) . 'Relation';
//        if ($this->name == 'comments')
//            dd(Config::getEntity('article'));
//            dd(Config::getModelsPath($this->related));

        if ($this->type != 'morph-to')
            $args = [Crudable::entity($this->related)->getModelClass()];
        else
            $args = [];

        foreach ($relationType::$methodArgs as $value)
            $args[] = $this->{$value};

        return [
            "name" => $relationType::$methodName,
            "args" => $args
        ];
    }
}



/**
 * @property string $methodName
 * @property array $methodArgs
 */
interface RelationTypeInterface {
}


class OTORelation implements RelationTypeInterface {
    public static $methodName = 'hasOne';
    public static $methodArgs = ['foreign_key', 'local_key'];
}


class OTMRelation implements RelationTypeInterface {
    public static $methodName = 'hasMany';
    public static $methodArgs = ['foreign_key', 'local_key'];
}

class OTMInverseRelation implements RelationTypeInterface {
    public static $methodName = 'belongsTo';
    public static $methodArgs = ['foreign_key', 'local_key'];
}

class MTMRelation implements RelationTypeInterface {
    public static $methodName = 'belongsToMany';
    public static $methodArgs = ['pivot_table', 'foreign_key', 'local_key'];
}

class MorphToRelation implements RelationTypeInterface {
    public static $methodName = 'morphTo';
    public static $methodArgs = ['morphable_name', 'morphable_type', 'morphable_id'];
}

class MorphOTOInverseRelation implements RelationTypeInterface {
    public static $methodName = 'morphOne';
    public static $methodArgs = ['morphable_name', 'morphable_type', 'morphable_id'];
}

class MorphOTMInverseRelation implements RelationTypeInterface {
    public static $methodName = 'morphMany';
    public static $methodArgs = ['morphable_name', 'morphable_type', 'morphable_id'];
}

class MorphMTMRelation implements RelationTypeInterface {
    public static $methodName = 'morphToMany';
    public static $methodArgs = ['morphable_name', 'morphable_type', 'morphable_id'];
}

class MorphMTMInverseRelation implements RelationTypeInterface {
    public static $methodName = 'morphedByMany';
    public static $methodArgs = ['morphable_name', 'morphable_type', 'morphable_id', 'local_key'];
}


