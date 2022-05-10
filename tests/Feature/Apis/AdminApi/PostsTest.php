<?php

use Igorsgm\Ghost\Facades\Ghost;
use Igorsgm\Ghost\Models\Resources\Author;
use Igorsgm\Ghost\Models\Resources\Post;
use Igorsgm\Ghost\Models\Resources\Tag;
use Igorsgm\Ghost\Models\Seo;
use Illuminate\Support\Facades\Http;

uses()->group('admin');
uses()->group('posts');

it('sets resource to Post::class', function () {
    $ghost = Ghost::admin()->posts();
    expect($ghost->getResource())->toBeInstanceOf(Post::class);
});

it('gets all posts', function () {
    Http::fake([
        "*admin/posts*" => Http::response($this->getFixtureJson('posts.json')),
    ]);

    $response = Ghost::admin()->posts()->all();
    expectSuccessfulResponse($response, Post::class);
});

it('gets all posts paginated', function () {
    $limit = 2;
    Http::fake([
        "*admin/posts/?limit=$limit*" => Http::response($this->getFixtureJson('posts-page-2.json')),
    ]);
    $response = Ghost::admin()->posts()->paginate($limit);
    expectSuccessfulResponse($response, Post::class);
    expect($response->meta->pagination)->not()->toBeEmpty();
});

it('gets next paginated page', function () {

    $limit = 2;
    Http::fake([
        "*admin/posts/?limit=$limit&page=2*" => Http::response($this->getFixtureJson('posts-page-2.json')),
        "*admin/posts/?limit=$limit*" => Http::response($this->getFixtureJson('posts-page-1.json')),
    ]);

    $response = Ghost::admin()->posts()->paginate($limit);

    $meta = $response->meta;
    expect($meta->page())->toEqual(1);
    expect($meta->limit())->toEqual($limit);
    expect($meta->pages())->toBeGreaterThanOrEqual(1);
    expect($meta->total())->toBeGreaterThanOrEqual(1);
    expect($meta->hasNext())->toBeTrue();
    expect($meta->next())->toBeGreaterThanOrEqual(2);

    $nextPageResponse = $response->getNextPage();
    expectSuccessfulResponse($nextPageResponse, Post::class);
    expect($nextPageResponse->data->count())->toBeLessThanOrEqual($limit);
    expect($nextPageResponse->meta->pagination->page)->toEqual(2);
});

it('gets previous paginated page', function () {
    $limit = 2;
    Http::fake([
        "*admin/posts/?limit=$limit&page=1*" => Http::response($this->getFixtureJson('posts-page-1.json')),
        "*admin/posts/?limit=$limit&page=2*" => Http::response($this->getFixtureJson('posts-page-2.json')),
    ]);

    $response = Ghost::admin()->posts()->page(2)->paginate($limit);

    $meta = $response->meta;
    expect($meta->hasPrev())->toBeTrue();
    expect($meta->prev())->toEqual(1);

    $previousPageResponse = $response->getPreviousPage();

    expectSuccessfulResponse($previousPageResponse, Post::class);
    expect($previousPageResponse->data->count())->toBeLessThanOrEqual($limit);
    expect($previousPageResponse->meta->pagination->page)->toEqual(1);
});

it('parses properties to Author, Tag and Seo classes', function () {
    Http::fake([
        sprintf('*admin/posts/?include=%s*',
            urlencode('authors,tags')) => Http::response($this->getFixtureJson('posts-page-1.json')),
    ]);

    $response = Ghost::admin()->posts()
        ->include(['authors', 'tags'])
        ->limit(1)
        ->get();

    expectSuccessfulResponse($response, Post::class);
    $post = $response->data->first();

    expectCollectionToBeEmptyOrInstanceOf($post->authors, Author::class);
    expectCollectionToBeEmptyOrInstanceOf($post->tags, Tag::class);

    if (!empty($post->primaryAuthor)) {
        expect($post->primaryAuthor)->toBeInstanceOf(Author::class);
    }

    if (!empty($post->primaryTag)) {
        expect($post->primaryTag)->toBeInstanceOf(Tag::class);
    }

    if (!empty($post->seo)) {
        expect($post->seo)->toBeInstanceOf(Seo::class);
    }
});

it('returns a post by ID', function () {
    $id = '626106438c3e1e2313c48715';
    Http::fake([
        "*admin/posts/$id/?*" => Http::response($this->getFixtureJson('posts.json')),
    ]);

    $ghost = Ghost::admin()->posts();
    $post = $ghost->find($id);

    expectEndpointParameterSet($ghost, 'resourceId', $id);
    expect($post)->toBeInstanceOf(Post::class)
        ->toHaveProperty('id', $id);
});

it('returns a post by slug', function () {
    $slug = 'my-test-post';
    Http::fake([
        "*admin/posts/slug/$slug/?*" => Http::response($this->getFixtureJson('posts.json')),
    ]);

    $ghost = Ghost::admin()->posts();
    $post = $ghost->fromSlug($slug);

    expectEndpointParameterSet($ghost, 'resourceSlug', $slug);
    expect($post)->toBeInstanceOf(Post::class)
        ->toHaveProperty('slug', $slug);
});
