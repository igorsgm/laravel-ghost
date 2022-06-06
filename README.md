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
___

## Usage
#### Define Ghost API credentials at `ghost.php` config or in your `.env` file. i.e.:
```
GHOST_ADMIN_DOMAIN=https://demo.ghost.io
GHOST_CONTENT_API_KEY=22444f78447824223cefc48062
GHOST_ADMIN_API_KEY=foo:bar
```

## Content API

### 1) General Usage 
```php
// Using the Facade (recommended), which will take the variables from the ghost.php config file
$contentApi = Ghost::content();
$response = $contentApi->posts()->all();

// Or you can set the variables manually
$contentApi = Ghost::content([
    'key' => '22444f78447824223cefc48062',
    'domain' => 'https://demo.ghost.io',
    'version' => 4
]);

$response = $contentApi->posts()->all();
$posts = $response->data;
$meta = $response->meta;
```

#### The Content API for `posts`, `pages`, `tags`, `authors`, `settings`, `tiers` are similiar and can be used with the following methods:

```php
// All resources returned as SuccessResponse (or ErrorResponse)
Ghost::content()->posts()->all();
Ghost::content()->authors()->all();
Ghost::content()->tags()->all();
Ghost::content()->pages()->all();
Ghost::content()->settings()->all();
Ghost::content()->tiers()->all();
```

#### Single resource returned as Post, Author, Tag, Page or Tier
```php
// Retrieve a single resource by slug
Ghost::content()->posts()->fromSlug('welcome');

// Retrieve first resource item
Ghost::content()->posts()->first();

// Retrieve a single resource by id
Ghost::content()->posts()->find('6285dbba44c5d85187a074ba');
```

#### Paginations
```php
// Get paginated resources
Ghost::content()->posts()->paginate();
$response = Ghost::content()->posts()->paginate(15);

$posts = $response->data;
$meta = $response->meta;

// Browse between pages
$response->getNextPage();
$response->getPreviousPage();
```

#### Build your request
> Valid for both: Ghost::content() and Ghost::admin() APIs

```php
Ghost::content()->posts()
    ->include('authors', 'tags') // https://ghost.org/docs/content-api/#include
    ->fields('title', 'slug', 'html') // https://ghost.org/docs/content-api/#fields
    ->formats('html') // https://ghost.org/docs/content-api/#formats
    ->filter('author:john+featured:true') // https://ghost.org/docs/content-api/#filtering
    ->limit(20) // https://ghost.org/docs/content-api/#limit
    ->page(2) // https://ghost.org/docs/content-api/#page
    ->orderBy('title', 'DESC') // https://ghost.org/docs/content-api/#order
    ->get();
```

## Admin API
- All ContentAPI methods related to Post, Author, Tag, Page or Tier are also available in the Admin API.

| Resource     | Methods                     |
|--------------|-----------------------------|
| ->posts()    | get, create, update, delete |
| ->pages()    | get, create, update, delete |
| ->tags()     | get, create, update, delete |
| ->tiers()    | get, create, update, delete |
| ->offers()   | get, create, update         |
| ->members()  | get, create, update         |
| ->users()    | get                         |
| ->images()   | upload                      |
| ->themes()   | upload, activate            |
| ->site()     | get                         |
| ->webhooks() | create, update, delete      |


#### (Admin) Posts, Pages, Tags, Tiers, Offers, Members, Users, Webhooks 
> The consume of these Admin APIs are similar and can be used with the following methods:
```php
// Create post with mobiledoc source
Ghost::admin()->posts()->create([
    'title' => 'My Test Post',
    'mobiledoc' => '{"version":"0.3.1","atoms":[],"cards":[],"markups":[],"sections":[[1,"p",[[0,[],0,"My post content. Work in progress..."]]]]}',
    'status' => 'published',
]);

// Create post with HTML source
Ghost::admin()->posts()->source('html')->create([
    'title' => 'My Test Post 2',
    'html' => '<p>My post content. Work in progress...</p>',
    'status' => 'published',
]);

// Update resource with mobiledoc source
// The updated_at field is required as it is used to handle collision detection, and ensure you’re not overwriting more recent updates.
// It is recommended to perform a GET request to fetch the latest data before updating a resource.
$post = Ghost::admin()->posts()->find($id);
Ghost::admin()->posts()->source('html')->update($id, [
    'title' => 'My New Title',
    'html' => '<p>My post content updated. Work in progress...</p>',
    'updated_at' => $post->updatedAt,
]);

// Delete resource by ID
Ghost::admin()->posts()->delete('6285dbba44c5d85187a074ba');
```

#### (Admin) Images, Themes
```php
// Upload image
$imagePathOrUrl = 'https://picsum.photos/200';
$response = Ghost::admin()->images()->upload($imagePathOrUrl);

// Upload theme (.zip)
$zipPathOrUrl = 'https://www.learningcontainer.com/wp-content/uploads/2020/05/sample-zip-file.zip';
$response = Ghost::admin()->themes()->upload($zipPathOrUrl);

// Activate a theme
Ghost::admin()->themes()->activate('theme-name');
```

___
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
