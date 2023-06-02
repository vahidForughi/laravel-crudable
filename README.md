# Generate Crud API From Entities Schema

Don`t need any more, Just fill your entities schema and enjoy ...

## Installation

You can install the package via composer:
``` bash
composer require vahidForughi/laravel-crudable
```


## Usage

api.php
```php
CrudableRoute::apiCrud('users');
CrudableRoute::apiCrud('articles.comments');
CrudableRoute::apiCrud('articles');
```

/config/entities.php
```php
"article" => [
    "slug" => "title",
    "fillable" => ["title", "slug", "content", "status"],
    "fields" => [
        "title" => ["type" => "text", "props" => [ "label" => "title" ]],
        "content" => ["type" => "textarea", "props" => [ "label" => "content" ]],
        "status" => ["type" => "select", "options" => [
            "type" => "constant", // static | constant | relation
            "items" => "publish_status"
        ]]
    ],
    "relations" => [
        [
            "name" =>  "comments",
            "type" => "morph-o-t-m-inverse",
            "related" => "Comment",
            "morphable_name" => "commentable",
            "morphable_type" => "commentable_type",
            "morphable_id" => "commentable_id",
            "foreign_key" => "",
            "local_key" => ""
        ]
    ],
    "rules" => [
        "title" => ["string"],
        "content" => ["min:3", "max:1000"]
    ],
    "permissions" => [],
    "routes" => [
        "store" => [
            "permissions" => [],
            "authorize" => true,
            "rules" => [
                "title" => ["required"],
                "content" => ["required"]
            ]
        ],
        "update" => []
    ],
]
```

Your APIs Are Ready !!!


## Configurations

This project have driver system to load entities schema from the config, json file, sql database, redis. 

/config/crudable.php
```php
"driver" => env('CRUDABLE_DRIVER', 'config'),
    
"store" => [
    'config' => [
        'driver' => 'config',
        'file' => 'entities'
    ],

    'json' => [
        'driver' => 'json',
        'file' => 'entities'
    ],

    'database' => [
        'driver' => 'database',
        'table' => 'entities',
        'connection' => 'mysql'
    ],

    'redis' => [
        'driver' => 'redis',
        'connection' => 'default'
    ],
]
```


## Costomize

You can use provided configuration or customize anything such as query, authorization, validation, model class, controllers and etc.

So you can create your own route and controller then use crudable entities handlers;

api.php
```php
CrudableRoute::apiCrud('articles', YourController::class);
```

controller.php
```php
// in constructor function
Crudable::init();
Crudable::handle([]);

// or in action function
Crudable::init();
Crudable::makeAuthorize();
Crudable::makeValidate();
Crudable::makeQuery();
Crudable::makeBeforeAction();
Crudable::makeAction();
Crudable::makeAfterAction();
Crudable::makeResponse();
```

Also you can bind your codes to crudable handlers to costomize that;

```php
Crudable::init();
$controller = Crudable::controller();

$controller->bind('after-authorize', fn () => {
    //somthing else
});

$controller->bind('query', fn () => {
    //somthing else
});

$controller->bind('before-action', fn () => {
    //somthing else
});
```

For extend or costomize models we provide some configuration in entities schema.

/config/entities.php
```php
//extend models
"user" => [
    "model_extended" => "Illuminate\Foundation\Auth\User",
    "model_uses" => [
        "Laravel\Sanctum\HasApiTokens",
        "Illuminate\Database\Eloquent\Factories\HasFactory",
        "Illuminate\Notifications\Notifiable"
    ],

    "fillable" => ["name","email","password"],
    "hidden" => ["password","remember_token"],
    // etc...
]

//or use your own
"user" => [
            "model_class" => "App\Models\User"
]
```


Store drivers costomizable too. So It's have an interface to create your own drivers.

```php
interface StoreDriver {
    public function all();
    public function keys();
    public function find(string $key);
    public function constants();
    public function constant($key);
}
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Testing

``` bash
composer test
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security

If you discover any security related issues, please email freek@generaltools.io instead of using the issue tracker.

## Postcardware

You're free to use this package.

## Credits

Nothing

## Support us

Generaltools is a webdesign agency based in Tehran, Iran. You'll find an overview of all our open source projects [on our website](https://generaltools.io).

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
