<?php

namespace Generaltools\Crudable\Classes\Entity;

use Generaltools\Crudable\Classes\Entity\Relation;
use Generaltools\Crudable\Classes\Entity\Route;
use Generaltools\Crudable\Classes\Stub;

class Entity0
{
    public string $name = '';
    public string $model = '';
    public string $table = '';
    public array $fields = [];
    public array $relations = [];
    public array $fillable = [];
    public array $guarded = [];
    public array $hidden = [];
    public array $casts = [];
    public array $appends = [];
    public array $routes = [];
    public array $rules = [];
    public array $permissions = [];

    function __construct($name, $schema) {
        $this->name = $name;
        $this->parseSchema($schema);
    }

    private function parseSchema($schema) : void
    {
        $this->setPropertiesFromSchema(array_filter($schema, function($value) {
            return in_array($value, ['model','table','fillable','guarded', 'hidden', 'casts', 'appends', 'fields', 'rules', 'permissions']);
        }, ARRAY_FILTER_USE_KEY));
//        $this->fillable = array_key_exists('fillable', $schema) ? $schema['fillable'] : [];
//        $this->hidden = array_key_exists('hidden', $schema) ? $schema['hidden'] : [];
//        $this->casts = array_key_exists('casts', $schema) ? $schema['casts'] : [];
//        $this->appends = array_key_exists('appends', $schema) ? $schema['appends'] : [];
//        $this->fields = array_key_exists('fields', $schema) ? $schema['fields'] : [];
//        $this->rules = array_key_exists('rules', $schema) ? $schema['rules'] : [];
//        $this->permissions = array_key_exists('permissions', $schema) ? $schema['permissions'] : [];
        if (array_key_exists('relations', $schema))
            $this->setRelationsFromSchema($schema['relations']);
        if (array_key_exists('routes', $schema))
            $this->setRoutesFromSchema($schema['routes']);
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

    private function setRoutesFromSchema($routesSchema) {
        $this->routes = [];
        foreach ($routesSchema as $name => $routeSchema) {
            $this->routes[] = new Route($name, $routeSchema);
        }
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
        $routeRules = ($route & isset($route->rules)) ? $route->rules: [];
        $rules = array_merge($routeRules, $this->rules);
        foreach ($rules as $fieldName => $rule) {
            $rules[$fieldName] = array_merge($routeRules[$fieldName], $this->rules[$fieldName]);
        }
        return $rules;
    }

    function getPermissions($route) {
        return array_merge($this->permissions[$route], $this->permissions);
    }


    public function evalEntityModel()
    {
        eval( Stub::getStub('EntityModel', [
            'EntityName' => $this->name,
            "EntityTable" => $this->table,
            "EntityFillable" => $this->fillable,
            "EntityGuarded" => $this->guarded,
            "EntityHidden" => $this->hidden,
            "EntityAppends" => $this->appends,
            "EntityCasts" => $this->casts
        ]));
    }
}
