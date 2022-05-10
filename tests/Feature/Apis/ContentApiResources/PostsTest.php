<?php

use Igorsgm\Ghost\Facades\Ghost;
use Igorsgm\Ghost\Models\Resources\Author;
use Igorsgm\Ghost\Models\Resources\Post;
use Igorsgm\Ghost\Models\Resources\Tag;
use Igorsgm\Ghost\Models\Seo;
use Igorsgm\Ghost\Responses\ErrorResponse;

it('sets resource to Post::class', function () {
    $ghost = Ghost::content()->posts();
    expect($ghost->getResource())->toBeInstanceOf(Post::class);
});

it('gets all posts', function () {
    $response = Ghost::content()->posts()->all();
    expectSuccessfulResponse($response, Post::class);
});

it('gets all posts paginated', function () {
    $limit = 5;
    $response = Ghost::content()->posts()->paginate($limit);
    expectSuccessfulResponse($response, Post::class);
    expect($response->meta->pagination)->not()->toBeEmpty();
});

it('gets next paginated page', function () {
    $limit = 5;
    $response = Ghost::content()->posts()->paginate($limit);

    expect($response->meta->hasNext())->toBeTrue();

    $nextPageResponse = $response->getNextPage();
    expectSuccessfulResponse($nextPageResponse, Post::class);
    expect($nextPageResponse->data->count())->toBeLessThanOrEqual($limit);
    expect($nextPageResponse->meta->pagination->page)->toEqual(2);
});

it('gets previous paginated page', function () {
    $limit = 5;
    $response = Ghost::content()->posts()->page(2)->paginate($limit);

    expect($response->meta->hasPrev())->toBeTrue();

    $previousPageResponse = $response->getPreviousPage();

    expectSuccessfulResponse($previousPageResponse, Post::class);
    expect($previousPageResponse->data->count())->toBeLessThanOrEqual($limit);
    expect($previousPageResponse->meta->pagination->page)->toEqual(1);
});

it('parses properties to Author, Tag and Seo classes', function () {
    $response = Ghost::content()->posts()
        ->include(['author', 'tags', 'primary_author'])
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
    $ghost = Ghost::content()->posts();
    $post = $ghost->find($this->defaultResourceId);

    expectEndpointParameterSet($ghost, 'resourceId', $this->defaultResourceId);
    expect($post)->toBeInstanceOf(Post::class)
        ->toHaveProperty('id', $this->defaultResourceId);
});

it('returns a post by slug', function () {
    $slug = 'welcome';

    $ghost = Ghost::content()->posts();
    $post = $ghost->fromSlug($slug);

    expectEndpointParameterSet($ghost, 'resourceSlug', $slug);
    expect($post)->toBeInstanceOf(Post::class)
        ->toHaveProperty('slug', $slug);
});

it('returns ErrorResponse on slug not found', function () {
    $ghost = Ghost::content()->posts();
    $response = $ghost->fromSlug('random-slug');

    expect($response)->toBeInstanceOf(ErrorResponse::class);
});
