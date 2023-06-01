<?php

namespace Generaltools\Crudable\Classes\Entity;


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
}


class FieldOption {
    public string $type;
    public $items;

    function __construct($type, $items){
        $this->type = $type;
        $this->items = $items;
    }
}

interface FieldOptionTypeInterface {}

class StaticFieldOption implements FieldOptionTypeInterface {}
class ConstantFieldOption implements FieldOptionTypeInterface {}
class RelationFieldOption implements FieldOptionTypeInterface {}



/**
 * @property string
 * @property array
 */
interface FieldTypeInterface {
}

class TextField implements FieldTypeInterface {

}

class EmailField implements FieldTypeInterface {

}

class PasswordField implements FieldTypeInterface {

}

class TextareaField implements FieldTypeInterface {

}

class CheckboxField implements FieldTypeInterface {

}

class RadioField implements FieldTypeInterface {

}

class SwitchField implements FieldTypeInterface {

}

class SelectField implements FieldTypeInterface {

}

class SliderField implements FieldTypeInterface {

}

class RangeSliderField implements FieldTypeInterface {

}

class FileField implements FieldTypeInterface {

}


