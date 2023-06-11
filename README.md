# Laravel model translation helpers

## Dependencies:
* php >=8.1 **REQUIRED IN YOUR PROJECT**
* laravel >=8 **REQUIRED IN YOUR PROJECT**
* laravel/helpers ^1.5 _composer will install it automatically_

## Installation:
```shell
composer require mphpmaster/laravel-model-translation-helpers
```

## Usage:
1. Add trait to your model class (**REQUIRED**): 
```php
use \MPhpMaster\LaravelModelTranslationHelpers\Traits\TModelTranslation;
```

2. Override this method if the model has custom translation filename (**OPTIONAL**): 
```php
public static function getTranslationKey(): ?string
{
    return str_singular(snake_case((new static)->getTable()));
}
```

3. Create Translation file (**REQUIRED**):
> * Translation file must be under `models` folder in order to use it with this helper.
> <br>
> * Name the file as you defined it with `getTranslationKey` method on step 2, by default the filename must be like model name in snake case.
> <br><br>
> **Example:**
> <br>
> If you use default `getTranslationKey` method it will be for model `User` as `user.php`.
```shell
touch lang/en/models/user.php
```

4. Default translation file will be like:
```php
<?php

return [
    'singular' => 'User',
    'plural' => 'Users',
    'fields' => [
        'id' => 'ID',
        'email' => 'Email',
        'password' => 'Password',
    ],
    'hi_name' => 'Hi, {name}',
];

?>
```

5. Use the helper anywhere:
```php
// Basic usage
\App\Models\User::trans('singular'); // User
\App\Models\User::trans('plural'); // Users

// fields:
\App\Models\User::trans('fields.email'); // Email
// or
\App\Models\User::trans('email'); // Email

// Advanced Usage:
\App\Models\User::trans('hi_name', [ 'name' => 'mPhpMaster' ], 'en', 'Please Login!'); // Hi, mPhpMaster
```


## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

This Helpers is open-sourced software licensed under the [MIT license](https://github.com/mPhpMaster/laravel-model-translation-helpers/blob/master/LICENSE).
