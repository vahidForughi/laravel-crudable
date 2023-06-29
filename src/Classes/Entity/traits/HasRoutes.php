<?php

namespace Generaltools\Crudable\Classes\Entity\traits;


trait HasRoutes
{

    public array $routes = [];
    public array $rules = [];
    public array $permissions = [];


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
            $rule = $this->convertRuleToArray($this->rules[$fieldName] ?? []);
            if (isset($routeRules[$fieldName]))
                $rules[$fieldName] = array_merge($this->convertRuleToArray($routeRules[$fieldName] ?? []), $rule);
            else
                $rules[$fieldName] = $rule;
        }
        return $rules;
    }


    function getPermissions($route) {
        return array_merge($this->permissions[$route], $this->permissions);
    }


    function convertRuleToArray($rule) : array {
        return is_array($rule) ? $rule : explode('|', $rule);
    }
}
