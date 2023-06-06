<?php

namespace Generaltools\Crudable\Classes\Entity\traits;

use Generaltools\Crudable\Utils\Names;
use Generaltools\Crudable\Classes\Entity\Field\Field;
use Generaltools\Crudable\Classes\Entity\Relation\Relation;
use Generaltools\Crudable\Classes\Entity\Route\Route;
use Generaltools\Crudable\Classes\Entity\Getter;
use Generaltools\Crudable\Classes\Entity\Setter;

trait HasModelSchema
{

    public string $table = '';
    public string $model_class = '';
    public string $model_extended = '';
    public array $model_uses = [];
    public array $fillable = [];
    public array $guarded = [];
    public array $hidden = [];
    public array $casts = [];
    public array $appends = [];
    public string $slug = '';

    public array $relations = [];

    public array $getters = [];
    public array $setters = [];

    public array $fields = [];


    
    private function parseSchemaProps($schema) : void
    {
        $this->setPropertiesFromSchema(array_filter($schema, function($value) {
            return in_array($value, ['model_class','model_extended','model_uses','slug','table','fillable','guarded', 'hidden', 'casts', 'appends', 'rules', 'permissions']);
        }, ARRAY_FILTER_USE_KEY));
        if (array_key_exists('fields', $schema))
            $this->setFieldsFromSchema($schema['fields']);
        if (array_key_exists('routes', $schema))
            $this->setRoutesFromSchema($schema['routes']);
        if (array_key_exists('relations', $schema))
            $this->setRelationsFromSchema($schema['relations']);
    }

    
    private function setPropertiesFromSchema($properties) : void {
        foreach ($properties as $property => $value)
            $this->{$property} = $value;
    }


    private function setRelationsFromSchema($relationsSchema) : void {
        $this->relations = [];
        foreach ($relationsSchema as $relationSchema)
            $this->relations[] = new Relation($relationSchema);
    }


    private function setFieldsFromSchema($fieldsSchema) {
        $this->fields = [];
        foreach ($fieldsSchema as $name => $fieldSchema)
            $this->setFieldAdditives($this->fields[] = new Field($name, $fieldSchema));
    }


    private function setRoutesFromSchema($routesSchema) {
        $this->routes = [];
        foreach ($routesSchema as $name => $routeSchema) {
            $this->routes[] = new Route($name, $routeSchema);
        }
    }

    
    private function setFieldAdditives($field) {
        $this->addUses($field->uses());
        $this->addGetter($field->name, function ($value) use ($field) {
            return $field->getter($value);
        });
        $this->addSetter($field->name, function ($value) use ($field) {
            return $field->setter($value);
        });
    }


    public function getTable()
    {
        if ($this->table)
            return $this->table;
        else
            return Names::tableName($this->name);
    }


    public function getModelClass()
    {
        if ($this->model_class)
            return $this->model_class;
        else
            return "\Generaltools\Crudable\Models\\".Names::modelName($this->name);
    }


    function addUses($class) {
        if (is_array($class)) {
            foreach ($class as $use) {
                if (in_array($class, $this->model_uses))
                    $this->model_uses[] = $class;
            }
        }
        else {
            if (in_array($class, $this->model_uses))
                $this->model_uses[] = $class;
        }
    }

    
    function addGetter($name, $callback) {
        $this->getters[] = new Getter($name, $callback);
    }


    function addSetter($name, $callback) {
        $this->setters[] = new Setter($name, $callback);
    }

}
