# SLIM 4 - API SKELETON

Useful framework for RESTful API development with JSON schema validation, using [Slim PHP micro framework](https://www.slimframework.com).

Used technologies: "PHP 7, Slim 4, MySQL, Doctrine, PHPUnit, dotenv & vagrant".

[![Software License][ico-license]](LICENSE.md)


[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat


## :gear: QUICK INSTALL:

### Requirements:

- Composer.
- PHP 7.2+.
- MySQL/MariaDB.
- or Vagrant.


### With Composer:

You can create a new project running the following commands:

```bash
$ composer create-project slim4/gslim-skeleton [my-app]
$ cd [my-app]
$ composer install
```


#### Configure your connection to MySQL Server:

By default, the API use a MySQL Database.

You should check and edit this configuration in your `.env` file:

```
APP_URL=http://yourproject.lo/
APP_DEBUG=true
APP_ID=1
APP_ENV=local

#Database
DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=gslim
DB_USERNAME=vagrant
DB_PASSWORD=vagrant
DB_CHARSET=utf8
DB_COLLATION=utf8_unicode_ci
DB_PREFIX=


# Cache twig
CACHE=false

#LOG_PATH
LOG_PATH='storage/logs/app.log'
```

## :package: DEPENDENCIES:

### LIST OF REQUIRE DEPENDENCIES:

- [slim/slim](https://github.com/slimphp/Slim): Slim is a PHP micro framework that helps you quickly write simple yet powerful web applications and APIs.
- [slim/psr7](https://github.com/slimphp/Slim-Psr7): PSR-7 implementation for use with Slim 4.
- [slim/csrf](https://github.com/slimphp/Slim-Psr7): Slim Framework CSRF Protection.
- [doctrine/orm](https://www.doctrine-project.org/projects/orm.html): Object Relational Mapper.
- [justinrainbow/json-schema](https://github.com/justinrainbow/json-schema): JSON Schema for PHP.
- [vlucas/phpdotenv](https://github.com/vlucas/phpdotenv): Loads environment variables from `.env` to `getenv()`, `$_ENV` and `$_SERVER` automagically.

### LIST OF DEVELOPMENT DEPENDENCIES:

- [phpunit/phpunit](https://github.com/sebastianbergmann/phpunit): The PHP Unit Testing framework.
- [symfony/console](https://github.com/symfony/console): The Console component eases the creation of beautiful and testable command line interfaces


# PHP Slim command line: $ php slim

```bash

  Slim Command Management Console 1.0

  Usage:
    command [options] [arguments]

  Options:
    -h, --help            Display help for the given command. When no command is given display help for the list command
    -q, --quiet           Do not output any message
    -V, --version         Display this application version
        --ansi            Force ANSI output
        --no-ansi         Disable ANSI output
    -n, --no-interaction  Do not ask any interactive question
    -v|vv|vvv, --verbose  Increase the verbosity of messages: 1 for normal output, 2 for more verbose output and 3 for debug

  Available commands:
    help              Display help for a command
    list              List commands
    migrate           Perform database migration

  make
    make:command      Create command file
    make:controller   Create interface controller
    make:entity       Create Entity e. g. UserAccess = tablename user_access
    make:exception    Create service interface
    make:middleware   Create Middleware
    make:migration    Create database migration file e. g. create_user_access_table / update_user_access_table
    make:service      Create service interface
    make:trait        Create interface trait
  migrate
    migrate:rollback  Roll back the database migration
  schedule
    schedule:run      Run timed task scheduling commands
```

## :bookmark: ENDPOINTS:

### BY DEFAULT:

- CSRF Token: `GET /api/token`

- Health Check: `GET /healthcheck`


## :sunglasses: THAT'S IT!

Now go build a cool SLIM API.
