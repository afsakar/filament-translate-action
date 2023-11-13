# Translate action for FilamentPHP

[![Latest Version on Packagist](https://img.shields.io/packagist/v/afsakar/filament-translate-action.svg?style=flat-square)](https://packagist.org/packages/afsakar/filament-translate-action)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/afsakar/filament-translate-action/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/afsakar/filament-translate-action/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/afsakar/filament-translate-action/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/afsakar/filament-translate-action/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/afsakar/filament-translate-action.svg?style=flat-square)](https://packagist.org/packages/afsakar/filament-translate-action)



This package provides a simple action to translate fields in FilamentPHP.

![Screenshot](https://raw.githubusercontent.com/afsakar/filament-translate-action/main/screenshot.png)

## Installation

You can install the package via composer:

```bash
composer require afsakar/filament-translate-action
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="filament-translate-action-config"
```

Optionally, you can publish the views using

```bash
php artisan vendor:publish --tag="filament-translate-action-views"
```

This is the contents of the published config file:

```php
return [
    'laravellocalization' => true, // if you use mcamara/laravel-localization package you can set this to true

    // if you don't use mcamara/laravel-localization package you can set your locales here
    'locales' => [
        'tr' => 'Türkçe',
        'en' => 'English',
    ],
];
```

## Usage

```php
...

RichEditor::make('body')
    ->label('Body')
    ->translatable() // add this line to make field translatable. That's it!
    ->required(),
    
...
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Azad Furkan ŞAKAR](https://github.com/afsakar)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
