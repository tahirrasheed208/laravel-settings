# Settings package for Laravel

[![Latest Version on Packagist](https://img.shields.io/packagist/v/tahirrasheed208/laravel-settings.svg?style=flat-square)](https://packagist.org/packages/tahirrasheed208/laravel-settings)
[![Total Downloads](https://img.shields.io/packagist/dt/tahirrasheed208/laravel-settings.svg?style=flat-square)](https://packagist.org/packages/tahirrasheed208/laravel-settings)

This package allows you to save settings in DB & Cache. You can use helper function to get settings value anywhere within laravel.

* Database support
* Helper function
* Cache support

## Getting Started

### 1. Install

Run the following command:

```bash
composer require tahirrasheed208/laravel-settings
```

### 2. Publish

Publish config file.

```bash
php artisan vendor:publish --tag=settings
```

### 3. Database

Create table in database.

```bash
php artisan migrate
```

### 4. Configure

You can change the options of your app from `config/settings.php` file

## Usage

### Helper

```php
setting()->get('foo');
setting()->get('foo', 'default');
setting()->put('foo', 'bar');
setting()->delete('foo');
```

### Facade

```php
Setting::get('foo');
Setting::get('foo', 'default');
Setting::put('foo', 'bar');
Setting::delete('foo');
```

## Changelog

Please see [Releases](../../releases) for more information what has changed recently.

## Contributing

Pull requests are more than welcome. You must follow the PSR coding standards.

## Security

If you discover any security related issues, please email tahirrasheedhtr@gmail.com instead of using the issue tracker.

## License

The MIT License (MIT). Please see [LICENSE](LICENSE.md) for more information.
