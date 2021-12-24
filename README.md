<p align="center">
    <img src="https://raw.githubusercontent.com/igorsgm/laravel-ghost/master/logo.png" alt="Laravel Ghost">
</p>

<p align="center">A Laravel wrapper that allows you to access Ghost APIs (Content & Admin). Access, create and manage your Ghost content from you app!</p>

<p align="center">
    <a href="https://packagist.org/packages/igorsgm/laravel-ghost">
        <img src="https://img.shields.io/packagist/v/igorsgm/laravel-ghost.svg?style=flat-square" alt="Latest Version on Packagist">
    </a>
    <a href="https://travis-ci.org/igorsgm/laravel-ghost">
        <img src="https://img.shields.io/scrutinizer/build/g/igorsgm/laravel-ghost/master?style=flat-square" alt="Build Status">
    </a>
    <a href="https://scrutinizer-ci.com/g/igorsgm/laravel-ghost">
        <img src="https://img.shields.io/scrutinizer/g/igorsgm/laravel-ghost.svg?style=flat-square" alt="Quality Score">
    </a>
    <a href="https://packagist.org/packages/igorsgm/laravel-ghost">
        <img src="https://img.shields.io/packagist/dt/igorsgm/laravel-ghost.svg?style=flat-square" alt="Total Downloads">
    </a>
</p>

<hr/>

## Installation

You can install the package via composer:

```bash
composer require igorsgm/laravel-ghost
```

You can publish the config file with:

```bash
php artisan vendor:publish --provider="Igorsgm\Ghost\GhostServiceProvider" --tag="ghost-config"
```

## Usage

```php
// Using the facade
Ghost::posts()->all();

// or
$ghost = new Ghost($content_key, $domain, string $version);
$ghost->posts()->all();
```

The API for `posts`, `authors`, `tags`, and `pages` is similiar and can be used with the following methods:

```php
// All resources returned as an array
Ghost::posts()->all();
Ghost::authors()->all();
Ghost::tags()->all();
Ghost::pages()->all();

// Retrieve a single resource by slug
Ghost::posts()->bySlug('welcome');

// Retrieve a single resource by id
Ghost::posts()->find('605360bbce93e1003bd6ddd6');

// Get full response from Ghost Content API including meta & pagination
Ghost::posts()->paginate();
$response = Ghost::posts()->paginate(15);

$posts = $response['posts'];
$meta = $response['meta'];
```

Build your request

```php
Ghost::posts()
    ->include('authors', 'tags')
    ->fields('title', 'slug', 'html')
    ->limit(20)
    ->page(2)
    ->orderBy('title')
    ->get();
```

### Testing

```bash
composer test
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email igor.sgm@gmail.com instead of using the issue tracker.

## Credits

- [Igor Moraes](https://github.com/igorsgm)
- [Michael Messerli](https://github.com/messerli90)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
