<?php

namespace Generaltools\Crudable\Utils;

use Illuminate\Support\Str;

class Names
{

    static function entityName($name) : string {
        return Str::snake(Str::singular($name));
    }

    static function modelName($name) : string {
        return Str::studly(Str::singular($name));
    }

    static function tableName($name) : string {
        return Str::snake(Str::pluralStudly($name));
    }

}
