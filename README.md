[![Build Status](https://travis-ci.org/benjamincrozat/blade.svg?branch=master)](https://travis-ci.org/benjamincrozat/blade)
[![Latest Stable Version](https://poser.pugx.org/benjamincrozat/blade/v/stable)](https://packagist.org/packages/benjamincrozat/blade)
[![License](https://poser.pugx.org/benjamincrozat/blade/license)](https://packagist.org/packages/benjamincrozat/blade)
[![Total Downloads](https://poser.pugx.org/benjamincrozat/blade/downloads)](https://packagist.org/packages/benjamincrozat/blade)

# Blade

Use [Laravel Blade](https://laravel.com/docs/blade) in any PHP project with minimal footprints.

## Requirements

- PHP 5.6+

## Installation

```php
composer require benjamincrozat/blade
```

## Usage

This package allows you to do almost everything you were able to do in a Laravel project.

Here is a basic view rendering:

```php
use BC\Blade\Blade;

$blade = new Blade(__DIR__ . '/views', __DIR__ . '/cache');

echo $blade->make('home')
    ->withSomeVariable('some value') // `$someVariable` will be available in your Blade file.
    ->render();
```

Add the `@hello('John')` directive:

```php
$blade->directive('hello', function ($expression) {
    return '<?php echo \'Hello ' . $expression . '\'; ?>';
});
```

Make a variable available in all views with view composers:

```php
$blade->composer('*', function ($view) {
    $view->withUser($this->container->get('auth')->user());
});
```

... and so on. Learn how to use Blade on the [official documentation](https://laravel.com/docs/blade).

Enjoy!

## License

[MIT](http://opensource.org/licenses/MIT)
