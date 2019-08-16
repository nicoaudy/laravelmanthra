# LaravelManthra

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Total Downloads][ico-downloads]][link-downloads]

This is where your description should go. Take a look at [contributing.md](contributing.md) to see a to do list.

## Installation

Via Composer

``` bash
$ composer require nicoaudy/laravelmanthra dev-master
```

Install **laravelcollective/html** form helper packages for if you haven't installed yet.

```bash
$ composer require laravelcollective/html
```

```bash
$ composer dump-autoload
```

Publish vendor files of this package.

```bash
$ php artisan vendor:publish
```


## Commands

#### Crud command:

Now you will be prompted two types of controller, API and Standard after executing the php artisan manthra command. 

If you pick API, your command should look like this (without --view-path=path): 
```
php artisan manthra:all Posts --fields="title#string; content#text; category#select#options=technology,tips,health" --controller-namespace=Admin --route-group=admin --model-namespace=Models
```

And this command to generate standard version :
```
php artisan manthra:all Posts --fields="title#string; content#text; category#select#options=technology,tips,health" --view-path=admin --controller-namespace=Admin --route-group=admin --model-namespace=Models
```

Options:

| Option                   | Description                                                                                                                                                                                                                                                                         |
| ------------------------ | ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| `--fields`               | Fields name for the form & migration. e.g. ```--fields="title#string; content#text; category#select#options=technology,tips,health; user_id#integer#unsigned"```                                                                                                                    |
| `--route`                | Include Crud route to routes.php? yes or no                                                                                                                                                                                                                                         |
| `--pk`                   | The name of the primary key                                                                                                                                                                                                                                                         |
| `--view-path`            | The name of the view path                                                                                                                                                                                                                                                           |
| `--controller-namespace` | The namespace of the controller - sub directories will be created                                                                                                                                                                                                                   |
| `--model-namespace`      | The namespace that the model will be placed in - directories will be created                                                                                                                                                                                                        |
| `--route-group`          | Prefix of the route group                                                                                                                                                                                                                                                           |
| `--pagination`           | The amount of models per page for index pages                                                                                                                                                                                                                                       |
| `--indexes`              | The fields to add an index to. append "#unique" to a field name to add a unique index. Create composite fields by separating fieldnames with a pipe (``` --indexes="title,field1|field2#unique" ``` will create normal index on title, and unique composite on fld1 and fld2)       |
| `--foreign-keys`         | Any foreign keys for the table. e.g. ```--foreign-keys="user_id#id#users#cascade"``` where user_id is the column name, id is the name of the field on the foreign table, users is the name of the foreign table, and cascade is the operation 'ON DELETE' together with 'ON UPDATE' |
| `--validations`          | Validation rules for the form "col_name#rules_set" e.g. ``` "title#min:10|max:30|required" ``` - See https://laravel.com/docs/master/validation#available-validation-rules                                                                                                          |
| `--relationships`        | The relationships for the model. e.g. ```--relationships="comments#hasMany#App\Comment"``` in the format                                                                                                                                                                            |
| `--localize`             | Allow to localize. e.g. localize=yes                                                                                                                                                                                                                                                |
| `--locales`              | Locales language type. e.g. locals=en                                                                                                                                                                                                                                               |

-----------


#### Other commands (optional):

For controller:

- Standard Version
```
php artisan manthra:controller PostsController --crud-name=posts --model-name=Post --view-path="directory" --route-group=admin
```

- API Version
```
php artisan manthra:api-controller PostsController --crud-name=posts --model-name=Post --route-group=admin
```

Controller's Options:

| Option                   | Description                                                                                                                                                                |
| ------------------------ | -------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| `--crud-name`            | The name of the crud. e.g. ```--crud-name="post"```                                                                                                                        |
| `--model-name`           | The name of the model. e.g. ```--model-name="Post"```                                                                                                                      |
| `--model-namespace`      | The namespace of the model. e.g. ```--model-namespace="Custom\Namespace\Post"```                                                                                           |
| `--controller-namespace` | The namespace of the controller. e.g. ```--controller-namespace="Http\Controllers\Client"```                                                                               |
| `--view-path`            | The name of the view path                                                                                                                                                  |
| `--fields`               | Fields name for the form & migration. e.g. ```--fields="title#string; content#text; category#select#options=technology,tips,health; user_id#integer#unsigned"```           |
| `--validations`          | Validation rules for the form "col_name#rules_set" e.g. ``` "title#min:10|max:30|required" ``` - See https://laravel.com/docs/master/validation#available-validation-rules |
| `--route-group`          | Prefix of the route group                                                                                                                                                  |
| `--pagination`           | The amount of models per page for index pages                                                                                                                              |
| `--force`                | Overwrite already existing controller.                                                                                                                                     |

For model:

```
php artisan manthra:model Post --fillable="['title', 'body']"
```

For migration:

```
php artisan manthra:migration posts --schema="title#string; body#text"
```

For view:

```
php artisan manthra:view posts --fields="title#string; body#text" --view-path="directory" --route-group=admin
```

By default, the generator will attempt to append the crud route to your ```Route``` file. If you don't want the route added, you can use this option ```--route=no```.

After creating all resources, run migrate command. *If necessary, include the route for your crud as well.*

```
php artisan migrate
```

If you chose not to add the crud route in automatically (see above), you will need to include the route manually.

```php
Route::resource('posts', 'PostsController');
```

### Supported Field Types

These fields are supported for migration and view's form:

#### Form Field Types:
* text
* textarea
* password
* email
* number
* date
* datetime
* time
* radio
* select
* file

#### Migration Field Types:
* string
* char
* varchar
* date
* datetime
* time
* timestamp
* text
* mediumtext
* longtext
* json
* jsonb
* binary
* integer
* bigint
* mediumint
* tinyint
* smallint
* boolean
* decimal
* double
* float
* enum


### Custom Generator's Stub Template

You can customize the generator's stub files/templates to achieve your need.

1. Make sure you've published package's assets.
    ```
    php artisan vendor:publish --provider="NicoAudy\LaravelManthra\LaravelManthraServiceProvider"
    ```

2. Turn on custom_template support on **config/laravelmanthra.php**
    ```
    'custom_template' => true,
    ```

3. From the directory **resources/manthra/stubs/** you can modify or customize the stub files.


4. On **config/laravelmanthra.php** you can add new stubs and choose which values are passed

## Support
<a href="https://www.buymeacoffee.com/sAb9PGzxT" target="_blank"><img src="https://bmc-cdn.nyc3.digitaloceanspaces.com/BMC-button-images/custom_images/orange_img.png" alt="Buy Me A Coffee" style="height: auto !important;width: auto !important;" ></a>

## Change log

Please see the [changelog](changelog.md) for more information on what has changed recently.

## Contributing

Please see [contributing.md](contributing.md) for details and a todolist.

## Security

If you discover any security related issues, please email author email instead of using the issue tracker.

## Credits

- [NicoAudy][link-author]
- [All Contributors][link-contributors]

## License

license. Please see the [license file](license.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/nicoaudy/laravelmanthra.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/nicoaudy/laravelmanthra.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/nicoaudy/laravelmanthra
[link-downloads]: https://packagist.org/packages/nicoaudy/laravelmanthra
[link-author]: https://github.com/nicoaudy
[link-contributors]: ../../contributors
