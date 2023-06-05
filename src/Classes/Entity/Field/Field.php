<?php

namespace Generaltools\Crudable\Classes\Entity\Field;

use Generaltools\Crudable\Classes\Crudable;
use Illuminate\Support\Str;

class Field
{
    public string $name;
    public string $type;
    public array $props;
    public FieldOption $options;

    function __construct($name, $schema) {
        $this->name = $name;
        $this->parseSchema($schema);
    }

    private function parseSchema($schema) {
        foreach ($schema as $key => $value) {
            if ($key == "options")
                $this->options = new FieldOption($value["type"], $value["items"]);
            else
                $this->{$key} = $value;
        }
    }

    function uses() {
        if (!empty($this->options))
            return $this->options->uses();
    }

    function getter($value) {
        if (!empty($this->options))
            return $this->options->getter($value);
    }

    function setter($value) {
        if (!empty($this->options))
            return $this->options->setter($value);
    }

}


class FieldOption {
    public $type;
    public $typeClass;
    public $items;

    function __construct($type, $items){
        $this->type = $type;
        $this->typeClass = __namespace__.'\\'.Str::studly($this->type).'FieldOption';
        $this->items = $items;
    }

    function uses() {
        return ($this->typeClass)::uses();
    }

    function getter($value) {
        return ($this->typeClass)::getter($this->items, $value);
    }

    function setter($value) {
        return ($this->typeClass)::setter($this->items, $value);
    }
}

interface FieldOptionTypeInterface {
    static function uses();
    static function getter($items, $value);
    static function setter($items, $value);
}


class StaticFieldOption implements FieldOptionTypeInterface {

    static function uses() {
        return [];
    }

    static function getter($items, $value) {
        return array_key_first(array_filter($items, function ($constant) use ($value) {
            return $constant == $value; 
        }));
    }

    static function setter($items, $value) {
        return $items[$value];
    }

}


class ConstantFieldOption implements FieldOptionTypeInterface {

    static function uses() {
        return [HasConstantVlue::class];
    }

    static function getter($items, $value) {
        return array_key_first(array_filter(Crudable::config()->constants($items), function ($constant) use ($value) {
            return $constant == $value; 
        }));
    }
    
    static function setter($items, $value) {
        $consants = Crudable::config()->constants($items);
        if (isset($consants[$value]))
            return $consants[$value];
    }

}


class RelationFieldOption implements FieldOptionTypeInterface {

    static function uses() {}

    static function getter($items, $value) {
        return $value;
    }

    static function setter($items, $value) {
        return $value;
    }

}



/**
 * @property string
 * @property array
 */
interface FieldTypeInterface {}


class TextField implements FieldTypeInterface {}


class EmailField implements FieldTypeInterface {}


class PasswordField implements FieldTypeInterface {}


class TextareaField implements FieldTypeInterface {}


class CheckboxField implements FieldTypeInterface {}


class RadioField implements FieldTypeInterface {}


class SwitchField implements FieldTypeInterface {}


class SelectField implements FieldTypeInterface {}


class SliderField implements FieldTypeInterface {}


class RangeSliderField implements FieldTypeInterface {}


class FileField implements FieldTypeInterface {}



