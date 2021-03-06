<?php

use Igorsgm\Ghost\Facades\Ghost;
use Igorsgm\Ghost\Models\Resources\Author;

uses()->group('content');
uses()->group('authors');

it('sets resource to Author::class', function () {
    $ghost = Ghost::content()->authors();
    expect($ghost->getResource())->toBeInstanceOf(Author::class);
});

it('gets all authors', function () {
    $response = Ghost::content()->authors()->all();
    expectSuccessfulResponse($response, Author::class);
});

it('gets all authors paginated', function () {
    $limit = 5;
    $response = Ghost::content()->authors()->paginate($limit);
    expectSuccessfulResponse($response, Author::class);
    expect($response->meta->pagination)->not()->toBeEmpty();
});

it('returns an author by ID', function () {
    $authorId = '5979a779df093500228e9590';
    $ghost = Ghost::content()->authors();
    $author = $ghost->find($authorId);

    expectEndpointParameterSet($ghost, 'resourceId', $authorId);
    expect($author)->toBeInstanceOf(Author::class)
        ->toHaveProperty('id', $authorId);
});

it('returns an author by slug', function () {
    $slug = 'abe';

    $ghost = Ghost::content()->authors();
    $author = $ghost->fromSlug($slug);

    expectEndpointParameterSet($ghost, 'resourceSlug', $slug);
    expect($author)->toBeInstanceOf(Author::class)
        ->toHaveProperty('slug', $slug);
});

it('returns first Author', function () {
    $author = Ghost::content()->authors()->first();
    expect($author)->toBeInstanceOf(Author::class);
});

it('includes count.posts', function () {
    $ghost = Ghost::content()->authors()->include('count.posts');
    expectQueryStringSet($ghost, 'include', 'count.posts');

    $response = $ghost->limit(1)->get();
    expectSuccessfulResponse($response, Author::class);

    $author = $response->data->first();
    expect($author)->toBeInstanceOf(Author::class);
    expect($author->postsCount)->toBeGreaterThanOrEqual(0);
});
