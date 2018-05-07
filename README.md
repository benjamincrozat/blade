[![Build Status](https://travis-ci.org/benjamincrozat/raw-blades.svg?branch=master)](https://travis-ci.org/benjamincrozat/raw-blades)
[![Latest Stable Version](https://poser.pugx.org/benjamincrozat/raw-blades/v/stable)](https://packagist.org/packages/benjamincrozat/raw-blades)
[![License](https://poser.pugx.org/benjamincrozat/raw-blades/license)](https://packagist.org/packages/benjamincrozat/raw-blades)
[![Total Downloads](https://poser.pugx.org/benjamincrozat/raw-blades/downloads)](https://packagist.org/packages/benjamincrozat/raw-blades)

# Raw Blades

Use Laravel Blade in any PHP project with minimal footprints.

## Installation

```php
composer require benjamincrozat/raw-blades
```

## Usage

Basic view render:

```php
$blade = new Blade(__DIR__ . '/views', __DIR__ . '/cache');

echo $blade->make('home')->render();
```

Custom directives:

```php
$blade->directive('foo', function () {
    //
});
```

Custom components:

```php
$blade->component('section', 'components.section');
```

## License

[MIT](http://opensource.org/licenses/MIT)
