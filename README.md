![Tests](https://github.com/benjamincrozat/blade/workflows/Tests/badge.svg)
[![Latest Stable Version](https://poser.pugx.org/benjamincrozat/blade/v/stable)](https://packagist.org/packages/benjamincrozat/blade)
[![Total Downloads](https://poser.pugx.org/benjamincrozat/blade/downloads)](https://packagist.org/packages/benjamincrozat/blade)

# Blade

Use [Laravel Blade](https://laravel.com/docs/blade) in any PHP project. The adapter class is clean and I don't make use of unecessary Laravel related dependencies.

**If you don't know about Blade yet, please refer to the [official documentation](https://laravel.com/docs/blade).**

## Installation

```php
composer require benjamincrozat/blade
```

## Usage

This package allows you to do almost everything you were able to do in a Laravel project.

Here is a basic view rendering:

```php
use BC\Blade\Blade;

$blade = new Blade('views', 'cache');

echo $blade->make('home')
    ->withFoo('bar')
    ->render();
```

Add the `@hello('John')` directive:

```php
$blade->directive('hello', function ($expression) {
    $expression = trim($expression, '\'"');

    return "<?php echo 'Hello $expression!'; ?>";
});
```

Make a variable available in all views thanks to view composers:

```php
$blade->composer('*', fn ($view) => $view->withFoo('bar'));
```

... and so on. Just use Blade as you are used to.

Enjoy!

## License

[WTFPL](http://www.wtfpl.net/txt/copying/)
