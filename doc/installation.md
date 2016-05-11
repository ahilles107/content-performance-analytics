# Installation

## Requirements

* PHP needs to be a minimum version of PHP 5.5.9
* JSON needs to be enabled
* ctype needs to be enabled
* Your php.ini needs to have the date.timezone setting
* postgresql
* php pgsql extension

## Set up Composer

Composer comes with a simple phar file. To easily access it from anywhere on your system, you can execute:

```
$ curl -s https://getcomposer.org/installer | php
$ sudo mv composer.phar /usr/local/bin/composer
```

## Create project

```
composer create-project "ahilles107/content-performance-analytics" -s dev
```
Installer will ask you about `database`, `max_points_*` and `good_value_*` and `google analytics` settings.

## Run application

```
php bin/console server:run
```
Now you can see application running here: `http://127.0.0.1:8000`

API documentation can be checked here: `http://127.0.0.1:8000/api/doc`
