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
            $rules[$fieldName] = isset($routeRules[$fieldName]) ? array_merge($routeRules[$fieldName], $this->rules[$fieldName]) : $this->rules[$fieldName];
        }
        return $rules;
    }


    function getPermissions($route) {
        return array_merge($this->permissions[$route], $this->permissions);
    }

}
