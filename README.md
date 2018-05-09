[![Build Status](https://travis-ci.org/benjamincrozat/blade.svg?branch=master)](https://travis-ci.org/benjamincrozat/blade)
[![Latest Stable Version](https://poser.pugx.org/benjamincrozat/blade/v/stable)](https://packagist.org/packages/benjamincrozat/blade)
[![License](https://poser.pugx.org/benjamincrozat/blade/license)](https://packagist.org/packages/benjamincrozat/blade)
[![Total Downloads](https://poser.pugx.org/benjamincrozat/blade/downloads)](https://packagist.org/packages/benjamincrozat/blade)

# Blade

Use [Laravel Blade](https://laravel.com/docs/blade) in any PHP project with minimal footprints.

## Installation

```php
composer require benjamincrozat/blade
```

## Usage

Basic view render:

```php
use BC\Blade\Blade;

$blade = new Blade(__DIR__ . '/views', __DIR__ . '/cache');

echo $blade->make('home')
    ->withSomeVariable('some value')
    ->render();
```

Learn how to use Blade on the [official documentation](https://laravel.com/docs/blade).  
Still using PHP 7.0? Check out the docoumentation for [Blade 5.5](https://laravel.com/docs/5.5/blade).

Enjoy!

## License

[MIT](http://opensource.org/licenses/MIT)
