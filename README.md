# Slim 4 MVC Skeleton

[![Codacy Badge](https://app.codacy.com/project/badge/Grade/62644bc058af464eb2cfcf564c3500d6)](https://www.codacy.com/gh/semhoun/slim-skeleton-mvc/dashboard?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=semhoun/slim-skeleton-mvc&amp;utm_campaign=Badge_Grade) [![Latest Stable Version](https://poser.pugx.org/semhoun/slim-skeleton-mvc/v/stable)](https://packagist.org/packages/semhoun/slim-skeleton-mvc) [![Total Downloads](https://poser.pugx.org/semhoun/slim-skeleton-mvc/downloads)](https://packagist.org/packages/semhoun/slim-skeleton-mvc) [![Latest Unstable Version](https://poser.pugx.org/semhoun/slim-skeleton-mvc/v/unstable)](https://packagist.org/packages/semhoun/slim-skeleton-mvc) [![License](https://poser.pugx.org/semhoun/slim-skeleton-mvc/license)](https://packagist.org/packages/semhoun/slim-skeleton-mvc) [![Monthly Downloads](https://poser.pugx.org/semhoun/slim-skeleton-mvc/d/monthly)](https://packagist.org/packages/semhoun/slim-skeleton-mvc)

This is a simple web application skeleton project that uses the [Slim4 Framework](http://www.slimframework.com/):
* [PHP-DI](http://php-di.org/) as dependency injection container
* [Slim-Psr7](https://github.com/slimphp/Slim-Psr7) as PSR-7 implementation
* [Eloquent](https://github.com/illuminate/database) as ORM
* [Twig](https://twig.symfony.com/) as template engine
* [Flash messages](https://github.com/slimphp/Slim-Flash)
* [Monolog](https://github.com/Seldaek/monolog)
* [Console](https://github.com/symfony/console)


## Prepare

1. Install dependencies
```bash
composer install
```
2. Configure database
3. Run migrations
```bash
vendor/bin/phinx migrate
```
4. Run seeders
```bash
vendor/bin/phinx seed:run
```
5. Run it
```bash
php -S 0.0.0.0:8888 -t public/
```