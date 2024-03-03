<?php

namespace Generaltools\Crudable\Classes\Entity\Relation;


use Generaltools\Crudable\Classes\Crudable;
use Generaltools\Crudable\Classes\Config;

class Relation
{
    const SAVE_METHODS = ['associate', 'sync', 'saveMany'];
    const ASSOCIATED_SAVE_METHOD = 'associate';
    const SYNC_SAVE_METHOD = 'sync';
    const SAVEMANY_SAVE_METHOD = 'saveMany';
    public $name;
    public $type;
    public $related;
    public $local_key;
    public $owner_key;
    public $foreign_key;
    public $pivot_table;
    public $morphable_name;
    public $morphable_table;
    public $morphable_type;
    public $morphable_id;
    public $method_name;
    public $method_args;
    public $save_method;
    public $with = [];
    public $fillablePivot = [];
    public $withPivot = [];
    public $withTimestamps = false;
    public $foreign_pivot_key;
    public $related_pivot_key;
    public $parent_key;
    public $related_key;
    public $relation;

    function __construct($schema) {
        $this->parseSchema($schema);
        $this->initMethods();
    }

    private function parseSchema($schema) : void {
        foreach ($schema as $key => $value) {
            $this->{$key} = $value;
        }
    }

    private function initMethods() : void {
        $methods = $this->getMethods();
        $this->method_name = $methods['name'];
        $this->method_args = $methods['args'];
        $this->save_method = $methods['save_method'];
    }

    protected function getMethods() : array {
        $relationType = __NAMESPACE__ . '\\' . str_replace('-', '', ucwords($this->type, '-')) . 'Relation';
        $relationClass = new $relationType;
        if ($relationClass::$needsRelatedClass)
            $args = [Crudable::entity($this->related)->getModelClass()];
        else
            $args = [];

        foreach ($relationClass::$methodArgs as $value)
            $args[] = $this->{$value};

//        return $relationClass::getMethods();
        return [
            "name" => $relationType::$methodName,
            "args" => $args,
            "save_method" => $relationType::$saveMethod
        ];
    }
}


class RelationMethods
{
    public string $name;
    public array $args;
    public string $saveMethod;

    function __construct (string $name, array $args, string $saveMethod) {
        $this->name = $name;
        $this->args = $args;
        $this->saveMethod = $saveMethod;
    }
}



/**
 * @property string $methodName
 * @property array $methodArgs
 * @property string $saveMethod
 */
abstract class RelationTypeAbstract {
    public static $methodName = '';
    public static $methodArgs = [];
    public static $saveMethod = '';
    public static $needsRelatedClass = true;

    public static function getMethods() : RelationMethods {
        return new RelationMethods(static::$methodName, static::$methodArgs, static::$saveMethod);
    }
}


class OTORelation extends RelationTypeAbstract {
    public static $methodName = 'hasOne';
    public static $methodArgs = ['foreign_key', 'local_key'];
    public static $saveMethod = 'sync';
}


class OTMRelation extends RelationTypeAbstract {
    public static $methodName = 'hasMany';
    public static $methodArgs = ['foreign_key', 'local_key'];
    public static $saveMethod = 'sync';
}

class OTMInverseRelation extends RelationTypeAbstract {
    public static $methodName = 'belongsTo';
    public static $methodArgs = ['foreign_key', 'owner_key', 'relation'];
    public static $saveMethod = 'associate';
}

class MTMRelation extends RelationTypeAbstract {
    public static $methodName = 'belongsToMany';
    public static $methodArgs = ['pivot_table', 'foreign_pivot_key', 'related_pivot_key', 'parent_key', 'related_key', 'relation'];
    public static $saveMethod = 'sync';
}

class MorphToRelation extends RelationTypeAbstract {
    public static $methodName = 'morphTo';
    public static $methodArgs = ['morphable_name', 'morphable_type', 'morphable_id', 'owner_key'];
    public static $saveMethod = 'sync';
    public static $needsRelatedClass = false;
}

class MorphOTOInverseRelation extends RelationTypeAbstract {
    public static $methodName = 'morphOne';
    public static $methodArgs = ['morphable_name', 'morphable_type', 'morphable_id', 'local_key'];
    public static $saveMethod = 'sync';
}

class MorphOTMInverseRelation extends RelationTypeAbstract {
    public static $methodName = 'morphMany';
    public static $methodArgs = ['morphable_name', 'morphable_type', 'morphable_id', 'local_key'];
    public static $saveMethod = 'saveMany';
}

class MorphMTMRelation extends RelationTypeAbstract {
    public static $methodName = 'morphToMany';
    public static $methodArgs = ['morphable_name', 'morphable_table', 'foreign_pivot_key', 'related_pivot_key', 'parent_key', 'related_key', 'relation'];
    public static $saveMethod = 'sync';
}

class MorphMTMInverseRelation extends RelationTypeAbstract {
    public static $methodName = 'morphedByMany';
    public static $methodArgs = ['morphable_name', 'morphable_table', 'foreign_pivot_key', 'related_pivot_key', 'parent_key', 'related_key', 'relation'];
    public static $saveMethod = 'sync';
}

