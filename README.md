## Installation

You can install the package via composer:

``` bash
composer require rjvim/permiso
```

The package will automatically register itself.

You can publish the migration with:
```bash
php artisan vendor:publish --provider="Betalectic\Permiso\PermisoServiceProvider" --tag="migrations"
```

```bash
php artisan migrate
```

You can optionally publish the config file with:
```bash
php artisan vendor:publish --provider="Betalectic\Permiso\PermisoServiceProvider" --tag="config"
```

## Documentation

* Register all permissions
* Build Strategy : Register/De-Register all entities
* Build Stragtegy to Set Parents of Entities

* Create Designation -> Choose permissions

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
