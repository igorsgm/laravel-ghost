<?php

use Igorsgm\Ghost\Facades\Ghost;
use Igorsgm\Ghost\Models\Resources\Tag;

uses()->group('content');
uses()->group('tags');

it('sets resource to Tag::class', function () {
    $ghost = Ghost::content()->tags();
    expect($ghost->getResource())->toBeInstanceOf(Tag::class);
});

it('gets all tags', function () {
    $response = Ghost::content()->tags()->all();
    expectSuccessfulResponse($response, Tag::class);
});

it('gets all tags paginated', function () {
    $limit = 5;
    $response = Ghost::content()->tags()->paginate($limit);
    expectSuccessfulResponse($response, Tag::class);
    expect($response->meta->pagination)->not()->toBeEmpty();
});

it('returns a tag by ID', function () {
    $tagId = '5979a779df093500228e958a';
    $ghost = Ghost::content()->tags();
    $tag = $ghost->find($tagId);

    expectEndpointParameterSet($ghost, 'resourceId', $tagId);
    expect($tag)->toBeInstanceOf(Tag::class)
        ->toHaveProperty('id', $tagId);
});

it('returns a tag by slug', function () {
    $slug = 'fables';

    $ghost = Ghost::content()->tags();
    $tag = $ghost->fromSlug($slug);

    expectEndpointParameterSet($ghost, 'resourceSlug', $slug);
    expect($tag)->toBeInstanceOf(Tag::class)
        ->toHaveProperty('slug', $slug);
});

it('includes count.posts', function () {
    $ghost = Ghost::content()->tags()->include('count.posts');
    expectQueryStringSet($ghost, 'include', 'count.posts');

    $response = $ghost->limit(1)->get();
    expectSuccessfulResponse($response, Tag::class);

    $tag = $response->data->first();
    expect($tag)->toBeInstanceOf(Tag::class);
    expect($tag->postsCount)->toBeGreaterThanOrEqual(0);
});
