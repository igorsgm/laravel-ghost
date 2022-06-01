<?php

use Igorsgm\Ghost\Facades\Ghost;
use Igorsgm\Ghost\Models\Resources\Post;
use Igorsgm\Ghost\Responses\ErrorResponse;
use Igorsgm\Ghost\Responses\SuccessResponse;

it('builds API endpoint (simple, with slug and with ID)', function () {
    $ghost = Ghost::content()->posts();
    $endpoint = invokeMethod($ghost, 'buildEndpoint');

    expect($endpoint)->toBe('posts');
    $ghost->resourceSlug = 'foo';

    $endpoint = invokeMethod($ghost, 'buildEndpoint');
    expect($endpoint)->toBe('posts/slug/foo');

    $ghost->resourceId = 1;
    $endpoint = invokeMethod($ghost, 'buildEndpoint');
    expect($endpoint)->toBe('posts/1');
});

it('makes full API url', function () {
    $ghost = Ghost::content()->posts();
    $apiUrl = invokeMethod($ghost, 'makeApiUrl');

    $expectedUrl = sprintf('%s/ghost/api/v%s/content/posts/?key=%s',
        $this->config->get('ghost.admin_domain'),
        $this->config->get('ghost.ghost_api_version'),
        $this->config->get('ghost.content_key')
    );

    expect($apiUrl)->toBe($expectedUrl);
});

it('sets includes using with()', function () {
    $ghost = Ghost::content();

    $ghost->with('authors');
    expectQueryStringSet($ghost, 'include', 'authors');
    $ghost->with('tags', 'authors');
    expectQueryStringSet($ghost, 'include', 'tags,authors');
    $ghost->with('count.posts');
    expectQueryStringSet($ghost, 'include', 'count.posts');
})->group('parameters');

it('sets includes using include()', function () {
    $ghost = Ghost::content();

    $ghost->include('authors');
    expectQueryStringSet($ghost, 'include', 'authors');
    $ghost->include('authors', 'tags');
    expectQueryStringSet($ghost, 'include', 'authors,tags');
    $ghost->include('count.posts');
    expectQueryStringSet($ghost, 'include', 'count.posts');
})->group('parameters');

it('sets includes from array', function () {
    $ghost = Ghost::content();

    $ghost->include(['authors', 'tags']);
    expect($ghost->include)->toBe('authors,tags');
    $ghost->with(['tags', 'authors']);
    expect($ghost->include)->toBe('tags,authors');
})->group('parameters');

it('sets fields', function () {
    $ghost = Ghost::content()->fields('title', 'url');
    expectQueryStringSet($ghost, 'fields', 'title,url');
})->group('parameters');

it('sets fields from array', function () {
    $ghost = Ghost::content()->fields(['url', 'title']);
    expectQueryStringSet($ghost, 'fields', 'url,title');
})->group('parameters');

it('sets formats', function () {
    $formats = 'plaintext';
    $ghost = Ghost::content()->formats($formats);
    expectQueryStringSet($ghost, 'formats', $formats);
})->group('parameters');

it('sets filter', function () {
    $filterString = 'featured:true+tag:getting-started';
    $ghost = Ghost::content()->filter($filterString);
    expectQueryStringSet($ghost, 'filter', $filterString);
})->group('parameters');

it('sets limit', function () {
    $limit = 10;
    $ghost = Ghost::content()->limit(10);
    expectQueryStringSet($ghost, 'limit', $limit);
})->group('parameters');

it('sets page', function () {
    $page = 2;
    $ghost = Ghost::content()->page($page);
    expectQueryStringSet($ghost, 'page', $page);
})->group('parameters');

it('sets order using "order()"', function () {
    $ghost = Ghost::content()->order('title', 'asc');
    expectQueryStringSet($ghost, 'order', 'title asc');
})->group('parameters');

it('sets order using "orderBy()"', function () {
    $ghost = Ghost::content()->orderBy('title', 'asc');
    expectQueryStringSet($ghost, 'order', 'title asc');
})->group('parameters');

it('sets and retrieves resource', function () {
    $resourceClass = Post::class;
    $ghost = Ghost::content();
    $ghost->setResource($resourceClass);

    expect(get_class($ghost->getResource()))->toBe($resourceClass);
});

it('builds query params with chained parameters', function () {
    $ghost = Ghost::content()->posts()
        ->include('tags')
        ->fields('id')
        ->formats('html')
        ->limit(1)
        ->page(1)
        ->order('id', 'desc');

    $queryString = invokeMethod($ghost, 'buildParams');
    parse_str($queryString, $parsedQueryString);

    expect($parsedQueryString)->toMatchArray([
        'key' => $this->config->get('ghost.content_key'),
        'include' => 'tags',
        'fields' => 'id',
        'formats' => 'html',
        'limit' => 1,
        'page' => 1,
        'order' => 'id desc',
    ]);

    $apiUrl = invokeMethod($ghost, 'makeApiUrl');

    $expectedUrl = sprintf('%s/ghost/api/v%s/content/posts/?%s',
        $this->config->get('ghost.admin_domain'),
        $this->config->get('ghost.ghost_api_version'),
        $queryString,
    );

    expect($apiUrl)->toBe($expectedUrl);
});

it('sets correct limit with paginated results', function () {
    $ghost = Ghost::content()->posts();
    $ghost->paginate(2);

    expectQueryStringSet($ghost, 'limit', 2);
});

it('sets correct limit with all() results', function () {
    $ghost = Ghost::content()->posts();
    $ghost->all();

    expectQueryStringSet($ghost, 'limit', 'all');
});

it('returns ErrorResponse when resourceId is not found on find().', function () {
    $response = Ghost::content()->posts()->find('foo-not-found');
    expect($response)->toBeInstanceOf(ErrorResponse::class);
});

it('returns Resource Model when resourceId is found on find().', function () {
    $ghost = Ghost::content()->posts();
    $response = $ghost->find('605360bbce93e1003bd6ddd6');
    expect($response)->toBeInstanceOf(get_class($ghost->getResource()));
});

it('returns SuccessResponse when all() is called.', function () {
    $response = Ghost::content()->posts()->all();
    expect($response)->toBeInstanceOf(SuccessResponse::class);
});
