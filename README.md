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

echo $blade->make('home')->render();
```

Assign variables:

```php
// First way.
$blade->make('home', ['foo' => 'bar'])->render();

// Expressive way.
$blade->make('home')->withFoo('bar')->render();
```

Custom directives:

```php
$blade->directive('foo', function () {
    //
});
```

Custom components:

```php
$blade->component('components.example', 'example');
```

Even view composers work:

```php
$blade->composer('*', function ($view) {
    // Every view will have access to the `$foo` variable.
    $view->withFoo('bar');
});
```

More on the [official documentation](https://laravel.com/docs/blade).

Enjoy!

## License

[MIT](http://opensource.org/licenses/MIT)
