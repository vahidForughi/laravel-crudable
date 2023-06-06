<?php

namespace Generaltools\Crudable\Classes\Entity\Field;

use Generaltools\Crudable\Classes\Crudable;
use Illuminate\Support\Str;

class Field
{
    public string $name;
    public string $type;
    public string $typeClass;
    public array $props;
    public ?FieldOption $options;

    function __construct($name, $schema) {
        $this->name = $name;
        $this->parseSchema($schema);
    }

    private function parseSchema($schema) {
        $this->type = $schema["type"];
        $this->typeClass = __namespace__.'\\'.Str::studly($this->type).'Field';
        $this->props = isset($schema["props"]) ? $schema["props"] : [];
        $this->options = isset($schema["options"]) ? new FieldOption($schema["options"]["type"], $schema["options"]["items"]) : null;
        // foreach ($schema as $key => $value) {
        //     if ($key == "options")
        //         $this->options = new FieldOption($value["type"], $value["items"]);
        //     else
        //         $this->{$key} = $value;
        // }
    }

    function uses() {
        return ($this->typeClass)::uses($this->options);
    }
    
    function getter($value) {
        return ($this->typeClass)::getter($value, $this->options);
    }
    
    function setter($value) {
        return ($this->typeClass)::setter($value, $this->options);
    }

}





/**
 * @property string
 * @property array
 */
class FieldType {
    static function uses() : array {
        return [];
    }
    static function getter($value, $options) {
        return $value;
    }
    static function setter($value, $options) {
        return $value;
    }
}


class TextField extends FieldType {}


class EmailField extends FieldType {}


class PasswordField extends FieldType {}


class TextareaField extends FieldType {}


class CheckboxField extends FieldType {}


class RadioField extends FieldType {}


class SwitchField extends FieldType {}


class SelectField extends FieldType {

    static function uses() : array {
        if (!empty($options))
            return $options->uses();
        else
            return [];
    }

    static function getter($value, $options) {
        if (!empty($options))
            return $options->getter($value);
        else
            return $value;
    }

    static function setter($value, $options) {
        if (!empty($options))
            return $options->setter($value);
        else
            return $value;
    }

}


class SliderField extends FieldType {}


class RangeSliderField extends FieldType {}


class FileField extends FieldType {}




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
        return ($this->typeClass)::getter($value, $this->items);
    }

    function setter($value) {
        return ($this->typeClass)::setter($value, $this->items);
    }
}

interface FieldOptionTypeInterface {
    static function uses();
    static function getter($value, $items);
    static function setter($value, $items);
}


class StaticFieldOption implements FieldOptionTypeInterface {

    static function uses() {
        return [];
    }

    static function getter($value, $items) {
        return array_key_first(array_filter($items, function ($constant) use ($value) {
            return $constant == $value; 
        }));
    }

    static function setter($value, $items) {
        return $items[$value];
    }

}


class ConstantFieldOption implements FieldOptionTypeInterface {

    static function uses() {
        return [HasConstantVlue::class];
    }

    static function getter($value, $items) {
        return array_key_first(array_filter(Crudable::config()->constants($items), function ($constant) use ($value) {
            return $constant == $value; 
        }));
    }
    
    static function setter($value, $items) {
        $consants = Crudable::config()->constants($items);
        if (isset($consants[$value]))
            return $consants[$value];
    }

}


class RelationFieldOption implements FieldOptionTypeInterface {

    static function uses() {}

    static function getter($value, $items) {
        return $value;
    }

    static function setter($value, $items) {
        return $value;
    }

}


