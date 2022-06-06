<?php

use Igorsgm\Ghost\Facades\Ghost;
use Igorsgm\Ghost\Models\Resources\Author;
use Igorsgm\Ghost\Models\Resources\Post;
use Igorsgm\Ghost\Models\Resources\Tag;
use Igorsgm\Ghost\Models\Seo;
use Igorsgm\Ghost\Responses\SuccessResponse;
use Illuminate\Support\Facades\Http;

uses()->group('admin');
uses()->group('posts');

it('sets resource to Post::class', function () {
    $ghost = Ghost::admin()->posts();
    expect($ghost->getResource())->toBeInstanceOf(Post::class);
});

it('gets all posts', function () {
    Http::fake([
        "*admin/posts*" => Http::response($this->getFixtureJson('posts-page-1.json')),
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
        "*admin/posts/$id/?*" => Http::response($this->getFixtureJson('posts-page-1.json')),
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
        "*admin/posts/slug/$slug/?*" => Http::response($this->getFixtureJson('posts-page-1.json')),
    ]);

    $ghost = Ghost::admin()->posts();
    $post = $ghost->fromSlug($slug);

    expectEndpointParameterSet($ghost, 'resourceSlug', $slug);
    expect($post)->toBeInstanceOf(Post::class)
        ->toHaveProperty('slug', $slug);
});

it('creates a post with mobiledoc source', function () {
    Http::fake([
        "*admin/posts/?*" => Http::response($this->getFixtureJson('post.json')),
    ]);

    $response = Ghost::admin()->posts()->create([
        'title' => 'My Test Post',
        'mobiledoc' => '{"version":"0.3.1","atoms":[],"cards":[],"markups":[],"sections":[[1,"p",[[0,[],0,"My post content. Work in progress..."]]]]}',
        'status' => 'published',
    ]);

    expectSuccessfulResponse($response, Post::class);

    $createdPost = $response->data->first();
    expect($createdPost)->toBeInstanceOf(Post::class)
        ->toHaveProperty('id');
});

it('creates a post with HTML source', function () {
    Http::fake([
        "*admin/posts/?*" => Http::response($this->getFixtureJson('post.json')),
    ]);

    $response = Ghost::admin()->posts()->source('html')->create([
        'title' => 'My Test Post 2',
        'html' => '<p>My post content. Work in progress...</p>',
        'status' => 'published',
    ]);

    expectSuccessfulResponse($response, Post::class);

    $createdPost = $response->data->first();
    expect($createdPost)->toBeInstanceOf(Post::class)
        ->toHaveProperty('id');
});

it('updates a post with mobiledoc', function () {
    $id = '6285dbba44c5d85187a074ba';

    // The updated_at field is required as it is used to handle collision detection,
    // and ensure you’re not overwriting more recent updates.
    // It is recommended to perform a GET request to fetch the latest data before updating a post.
    Http::fake([
        "*admin/posts/$id/?*" => Http::response($this->getFixtureJson('post.json')),
    ]);

    $post = Ghost::admin()->posts()->find($id);
    $response = Ghost::admin()->posts()->update($id, [
        'title' => 'My New Title',
        'mobiledoc' => '{"version":"0.3.1","atoms":[],"cards":[],"markups":[],"sections":[[1,"p",[[0,[],0,"My updated post content. Work in progress..."]]]]}',
        'updated_at' => $post->updatedAt,
    ]);

    expectSuccessfulResponse($response, Post::class);

    $createdPost = $response->data->first();
    expect($createdPost)->toBeInstanceOf(Post::class)
        ->toHaveProperty('id');
});

it('deletes a post', function () {
    $id = '6285dbba44c5d85187a074ba';

    //Delete requests have no payload in the request or response. Successful deletes will return an empty 204 response.
    Http::fake([
        "*admin/posts/$id/?*" => Http::response('', 204),
    ]);

    $response = Ghost::admin()->posts()->delete($id);

    expect($response)->toBeInstanceOf(SuccessResponse::class);
    expect($response->data)->toBeEmpty();
});
