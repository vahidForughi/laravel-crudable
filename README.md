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

This project have driver system to load entities schema from the config, json file, sql database, redis. So It's have an interface to create your own drivers too.

```php
interface StoreDriver {
    public function all();
    public function keys();
    public function find(string $key);
    public function constants();
    public function constant($key);
}
```


## Costomize

You can use provided configuration or customize anything such as query, authorization, validation, model class, controllers and etc.

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

// or you can bind
Crudable::init();
$controller = Crudable::controller();
$controller->bind('after-authorize', fn () => {
    //somthing else
});
$controller->bind('before-action', fn () => {
    //somthing else
});
Crudable::handle([]);
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

Spatie is a webdesign agency based in Antwerp, Belgium. You'll find an overview of all our open source projects [on our website](https://generaltools.io).

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
