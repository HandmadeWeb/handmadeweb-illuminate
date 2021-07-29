[![Latest Version on Packagist](https://img.shields.io/packagist/v/handmadeweb/hookable-actions-filters.svg?style=flat-square)](https://packagist.org/packages/handmadeweb/hookable-actions-filters)
[![Total Downloads](https://img.shields.io/packagist/dt/handmadeweb/hookable-actions-filters.svg?style=flat-square)](https://packagist.org/packages/handmadeweb/hookable-actions-filters) 
[![MIT Licensed](https://img.shields.io/badge/license-MIT-blue.svg?style=flat-square)](LICENSE.md)
[![Run Tests](https://github.com/handmadeweb/hookable-actions-filters/actions/workflows/tests.yml/badge.svg)](https://github.com/handmadeweb/hookable-actions-filters/actions/workflows/tests.yml)

Hookable Actions And Filters is an Action and Filter library inspired by WordPress's Actions and Filters.
This package can be used in Laravel and supports auto discovery, alternatively the package can also be used in any PHP project.

## Installation

You can install the package via composer:

```bash
composer require handmadeweb/hookable-actions-filters
```

## Usage

### Action Examples
``` php

use HandmadeWeb\ActionsAndFilters\Action;

// Eample function for test
function action_test($key){
    unset($_GET[$key]);
}

// Add a action callback to a function by name
Action::add('unset', 'action_test');
// Or

// Add a action callback to a closure function
Action::add('unset', function($key){
    action_test($key);
    // Or this closure function could just do unset($_GET[$key]);
});

// Execute the action, which in this example will unset $_GET['foobar']
Action::run('unset', 'foobar');

```

### Filter Examples
``` php

use HandmadeWeb\ActionsAndFilters\Filter;

// Add a filter callback to a function by name
Filter::add('Test', 'ucfirst');

// Add a filter callback to a closure function
Filter::add('Test', function($value){
    return "{$value} {$value}";
});

// Will return Foobar Foobar
Filter::run('Test', 'foobar');

```

## Testing

``` bash
composer test
```

## Changelog

Please see [CHANGELOG](https://github.com/handmadeweb/hookable-actions-filters/blob/master/CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](https://github.com/handmadeweb/hookable-actions-filters/blob/master/CONTRIBUTING.md) for details.

## Security

If you discover any security related issues, please email michael@rook.net.au instead of using the issue tracker.

## Credits

- [Handmade Web & Design](https://github.com/handmadeweb)
- [Michael Rook](https://github.com/michaelr0)
- [All Contributors](https://github.com/handmadeweb/hookable-actions-filters/graphs/contributors)

## License

The MIT License (MIT). Please see [License File](https://github.com/handmadeweb/hookable-actions-filters/blob/master/LICENSE.md) for more information.
