# Translate action for FilamentPHP

[![Latest Version on Packagist](https://img.shields.io/packagist/v/afsakar/filament-translate-action.svg?style=flat-square)](https://packagist.org/packages/afsakar/filament-translate-action)
[![Total Downloads](https://img.shields.io/packagist/dt/afsakar/filament-translate-action.svg?style=flat-square)](https://packagist.org/packages/afsakar/filament-translate-action)

![Screenshot](https://banners.beyondco.de/Filament%20Translate%20Action.png?theme=light&packageManager=composer+require&packageName=afsakar%2Ffilament-translate-action&pattern=architect&style=style_2&description=Translate+action+for+FilamentPHP&md=1&showWatermark=1&fontSize=100px&images=https%3A%2F%2Flaravel.com%2Fimg%2Flogomark.min.svg)

This package provides a simple action to translate fields in FilamentPHP.

## Installation

You can install the package via composer:

```bash
composer require afsakar/filament-translate-action
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="filament-translate-action-config"
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

## Screenshot

![Screenshot](https://raw.githubusercontent.com/afsakar/filament-translate-action/main/art/filament-translatable-action.gif)

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
