# Laravel Boilerplate (+Gemboot)

[![Latest Stable Version](https://poser.pugx.org/gem-partij/laravel-boilerplate/v/stable)](https://packagist.org/packages/gem-partij/laravel-boilerplate)
[![Total Downloads](https://poser.pugx.org/gem-partij/laravel-boilerplate/downloads)](https://packagist.org/packages/gem-partij/laravel-boilerplate)
[![Latest Unstable Version](https://poser.pugx.org/gem-partij/laravel-boilerplate/v/unstable)](https://packagist.org/packages/gem-partij/laravel-boilerplate)
[![License](https://poser.pugx.org/gem-partij/laravel-boilerplate/license)](https://packagist.org/packages/gem-partij/laravel-boilerplate)
[![Monthly Downloads](https://poser.pugx.org/gem-partij/laravel-boilerplate/d/monthly)](https://packagist.org/packages/gem-partij/laravel-boilerplate)
[![Daily Downloads](https://poser.pugx.org/gem-partij/laravel-boilerplate/d/daily)](https://packagist.org/packages/gem-partij/laravel-boilerplate)
[![composer.lock](https://poser.pugx.org/gem-partij/laravel-boilerplate/composerlock)](https://packagist.org/packages/gem-partij/laravel-boilerplate)

Laravel standard boilerplate + gemboot installation + jwt auth

## Installation via Composer

If your computer already has PHP and Composer installed, you may create a new project by using Composer directly. After the application has been created, you may start Laravel's local development server using the Artisan CLI's serve command:

```sh
composer create-project gem-partij/laravel-boilerplate example-app
```

```sh
cd example-app
```

```sh
php artisan serve
```

## Installation via Docker

If your computer already has Docker installed, you may create a new project by using Docker directly:

```sh
docker run --rm --interactive --tty \
  --volume $PWD:/app \
  --volume ${COMPOSER_HOME:-$HOME/.composer}:/tmp \
  composer create-project gem-partij/laravel-boilerplate example-app --ignore-platform-reqs
```

```sh
cd example-app
```

```sh
docker-compose up
```

## Documentations

#### Laravel

See the [LARAVEL DOCUMENTATION](https://laravel.com/docs) for detailed installation and usage instructions.

#### Gemboot

See the [GEMBOOT DOCUMENTATION](https://github.com/gem-partij/gemboot-lara/tree/master/docs) for detailed installation and usage instructions.
