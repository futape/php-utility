# futape/php-utility

This library offers a set of PHP utilities.

Utility functions are implemented as static functions in an abstract class, which is never expected to be instantiated.

## Install

```bash
composer require futape/php-utility
```

## Usage

```php
use Futape\Utility\Php\Php;

var_dump(Php::isValidVariableName('0foo')); // false
```

## Testing

The library is tested by unit tests using PHP Unit.

To execute the tests, install the composer dependencies (including the dev-dependencies), switch into the `tests`
directory and run the following command:

```bash
../vendor/bin/phpunit
```
