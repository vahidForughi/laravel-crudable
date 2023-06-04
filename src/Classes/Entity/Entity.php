<?php

namespace Generaltools\Crudable\Classes\Entity;

use Generaltools\Crudable\Classes\Crudable;
use Generaltools\Crudable\Classes\traits\HasConstantValue;
use Generaltools\Crudable\Utils\Names;
use Generaltools\Crudable\Utils\Stub;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Entity
{
    public string $name = '';
    public string $model_class = '';
    public string $model_extended = '';
    public array $model_uses = [];
    public string $slug = '';
    public string $table = '';
    public array $fields = [];
    public array $constants = [];
    public array $relations = [];
    public array $fillable = [];
    public array $guarded = [];
    public array $hidden = [];
    public array $casts = [];
    public array $appends = [];
    public array $routes = [];
    public array $rules = [];
    public array $permissions = [];
    public array $getters = [];
    public array $setters = [];


    function __construct($name, $schema) {
        $this->name = $name;
        if ($schema)
            $this->parseSchemaProps($schema);
    }


    function init($schema): void {
        if ($schema)
            $this->parseSchemaRelations($schema);
        $this->evalModel();
    }


    private function parseSchemaProps($schema) : void
    {
        $this->setPropertiesFromSchema(array_filter($schema, function($value) {
            return in_array($value, ['model_class','model_extended','model_uses','slug','table','fillable','guarded', 'hidden', 'casts', 'appends', 'rules', 'permissions']);
        }, ARRAY_FILTER_USE_KEY));
        if (array_key_exists('fields', $schema))
            $this->setFieldsFromSchema($schema['fields']);
        if (array_key_exists('routes', $schema))
            $this->setRoutesFromSchema($schema['routes']);
    }


    private function parseSchemaRelations($schema) : void
    {
        if (array_key_exists('relations', $schema))
            $this->setRelationsFromSchema($schema['relations']);
    }

    function __toString() {
        return json_decode( json_encode($this), true);
    }


    public function evalModel()
    {
//        if ($this->name == 'article'){
// //            dd($this->getters);
// //            dd(( json_decode(json_encode($this->getters), true)));
// //            dd(Convertor::arrayToBladeString(json_decode( json_encode($this), true)));
//            $template = Stub::getView('model',[
//                "Entity" => $this
//            ]);
//            dd($template);
//        }
        eval( Stub::getView('model', [
//            'Convertor' => Convertor::class,
//            'Name' => Names::modelName($this->name),
//            'Extended' => $this->model_extended,
//            'Uses' => $this->model_uses,
//            'Slug' => $this->slug,
//            "Table" => $this->getTable(),
//            "Fillable" => $this->fillable,
//            "Guarded" => $this->guarded,
//            "Hidden" => $this->hidden,
//            "Appends" => $this->appends,
//            "Casts" => $this->casts,
//            "Fields" => $this->fields,
//            "Getters" => $this->getters,
//            "Setters" => $this->setters,
//            "Relations" => $this->relations
            "Entity" => $this
        ]));
    }


    private function setPropertiesFromSchema($properties) : void {
        foreach ($properties as $property => $value) {
            $this->{$property} = $value;
        }
    }


    private function setRelationsFromSchema($relationsSchema) : void {
        $this->relations = [];
        foreach ($relationsSchema as $relationSchema) {
            $this->relations[] = new Relation($relationSchema);
        }
    }


    private function setFieldsFromSchema($fieldsSchema) {
        $this->fields = [];
        foreach ($fieldsSchema as $name => $fieldSchema) {
            $field = new Field($name, $fieldSchema);
            $this->setFieldAdditives($field);
            $this->fields[] = $field;
        }
    }


    private function setFieldAdditives($field) {
        if (isset($field->options) && $field->options && $field->options->type == "constant") {
            $this->addUses(HasConstantValue::class);
            $this->addGetter($field->name, function ($value) use ($field) {
                return array_key_first(array_filter(Crudable::config()->constants($field->options->items), function ($constant) use ($value) { return $constant == $value; }));
            });
            $this->addSetter($field->name, function ($value) use ($field) {
                return Crudable::config()->constants($field->options->items)[$value];
            });
        }
    }


    private function setRoutesFromSchema($routesSchema) {
        $this->routes = [];
        foreach ($routesSchema as $name => $routeSchema) {
            $this->routes[] = new Route($name, $routeSchema);
        }
    }


    public function getModelClass()
    {
        if ($this->model_class)
            return $this->model_class;
        else
            return "\Generaltools\Crudable\Models\\".Names::modelName($this->name);
    }


    public function getTable()
    {
        if ($this->table)
            return $this->table;
        else
            return Names::tableName($this->name);
    }


    function getRoute($name) {
        foreach ($this->routes as $route) {
            if ($route->name == $name)
                return $route;
        }
        return null;
    }


    function getRules($routeAction) {
        $route = $this->getRoute($routeAction);
        $routeRules = ($route && $route->rules) ? $route->rules: [];
        $rules = array_merge($routeRules, $this->rules);
        foreach ($rules as $fieldName => $rule) {
            $rules[$fieldName] = isset($routeRules[$fieldName]) ? array_merge($routeRules[$fieldName], $this->rules[$fieldName]) : $this->rules[$fieldName];
        }
        return $rules;
    }


    function getPermissions($route) {
        return array_merge($this->permissions[$route], $this->permissions);
    }


    function addUses($class) {
        if (in_array($class, $this->model_uses))
            $this->model_uses[] = $class;
    }


    function addGetter($name, $callback) {
        $this->getters[] = new Getter($name, $callback);
    }


    function addSetter($name, $callback) {
        $this->setters[] = new Setter($name, $callback);
    }
}


class Getter {
    public string $name;
    public $callback;

    function __construct($name, $callback) {
        $this->name = $name;
        $this->callback = $callback;
    }

    function call($value) {
        return ($this->callback)($value);
    }
}

class Setter {
    public string $name;
    public $callback;

    function __construct($name, $callback) {
        $this->name = $name;
        $this->callback = $callback;
    }

    function call($value) {
        return ($this->callback)($value);
    }
}
