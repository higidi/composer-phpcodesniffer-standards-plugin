About
-----

Composer plugin installs [PHP_CodeSniffer](https://github.com/squizlabs/PHP_CodeSniffer) Standards.

[![build status](https://git.higidi.com/higidi/composer-phpcodesniffer-standards-plugin/badges/master/build.svg)](https://git.higidi.com/higidi/composer-phpcodesniffer-standards-plugin/commits/master) [![coverage report](https://git.higidi.com/higidi/composer-phpcodesniffer-standards-plugin/badges/master/coverage.svg)](https://git.higidi.com/higidi/composer-phpcodesniffer-standards-plugin/commits/master) [![Latest Stable Version](https://poser.pugx.org/higidi/composer-phpcodesniffer-standards-plugin/v/stable)](https://packagist.org/packages/higidi/composer-phpcodesniffer-standards-plugin) [![Total Downloads](https://poser.pugx.org/higidi/composer-phpcodesniffer-standards-plugin/downloads)](https://packagist.org/packages/higidi/composer-phpcodesniffer-standards-plugin) [![License](https://poser.pugx.org/higidi/composer-phpcodesniffer-standards-plugin/license)](https://packagist.org/packages/higidi/composer-phpcodesniffer-standards-plugin)

Requirements
------------

- `PHP >= 5.3.3`
- Composer package providing the PHP CodeSniffer Rulesets & Sniffs

Installation
------------

```bash
$ composer require higidi/composer-phpcodesniffer-standards-plugin
```

Change the type of your composer package to `phpcodesniffer-standard` (or optional to `phpcodesniffer-standards`, both will work)

Your composer.json should looks like:
```json
{
    "name": "vendor/my-php-codesniffer-standards",
    "description": "My codesniffer standards",
    "type": "phpcodesniffer-standard",
    "require": {
        "higidi/composer-phpcodesniffer-standards-plugin": "^1.0"
    }
}
```

Issues
------

Bug reports and feature requests can be submitted on the [Issue Tracker](https://git.higidi.com/higidi/composer-phpcodesniffer-standards-plugin/issues) 
