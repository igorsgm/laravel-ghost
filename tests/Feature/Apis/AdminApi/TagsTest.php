<?php

use Igorsgm\Ghost\Facades\Ghost;
use Igorsgm\Ghost\Models\Resources\Tag;
use Igorsgm\Ghost\Models\Seo;
use Igorsgm\Ghost\Responses\SuccessResponse;
use Illuminate\Support\Facades\Http;

uses()->group('admin');
uses()->group('tags');

it('sets resource to Tag::class', function () {
    $ghost = Ghost::admin()->tags();
    expect($ghost->getResource())->toBeInstanceOf(Tag::class);
});

it('gets all tags', function () {
    Http::fake([
        "*admin/tags*" => Http::response($this->getFixtureJson('tags-page-1.json')),
    ]);

    $response = Ghost::admin()->tags()->all();
    expectSuccessfulResponse($response, Tag::class);
});

it('gets all tags paginated', function () {
    $limit = 2;
    Http::fake([
        "*admin/tags/?limit=$limit*" => Http::response($this->getFixtureJson('tags-page-2.json')),
    ]);
    $response = Ghost::admin()->tags()->paginate($limit);
    expectSuccessfulResponse($response, Tag::class);
    expect($response->meta->pagination)->not()->toBeEmpty();
});

it('gets next paginated tag', function () {

    $limit = 2;
    Http::fake([
        "*admin/tags/?limit=$limit&page=2*" => Http::response($this->getFixtureJson('tags-page-2.json')),
        "*admin/tags/?limit=$limit*" => Http::response($this->getFixtureJson('tags-page-1.json')),
    ]);

    $response = Ghost::admin()->tags()->paginate($limit);

    $meta = $response->meta;
    expect($meta->page())->toEqual(1);
    expect($meta->limit())->toEqual($limit);
    expect($meta->pages())->toBeGreaterThanOrEqual(1);
    expect($meta->total())->toBeGreaterThanOrEqual(1);
    expect($meta->hasNext())->toBeTrue();
    expect($meta->next())->toBeGreaterThanOrEqual(2);

    $nextPageResponse = $response->getNextPage();
    expectSuccessfulResponse($nextPageResponse, Tag::class);
    expect($nextPageResponse->data->count())->toBeLessThanOrEqual($limit);
    expect($nextPageResponse->meta->pagination->page)->toEqual(2);
});

it('gets previous paginated tag', function () {
    $limit = 2;
    Http::fake([
        "*admin/tags/?limit=$limit&page=1*" => Http::response($this->getFixtureJson('tags-page-1.json')),
        "*admin/tags/?limit=$limit&page=2*" => Http::response($this->getFixtureJson('tags-page-2.json')),
    ]);

    $response = Ghost::admin()->tags()->page(2)->paginate($limit);

    $meta = $response->meta;
    expect($meta->hasPrev())->toBeTrue();
    expect($meta->prev())->toEqual(1);

    $previousTagResponse = $response->getPreviousPage();

    expectSuccessfulResponse($previousTagResponse, Tag::class);
    expect($previousTagResponse->data->count())->toBeLessThanOrEqual($limit);
    expect($previousTagResponse->meta->pagination->page)->toEqual(1);
});

it('parses properties Seo class', function () {
    Http::fake([
        '*admin/tags/?*' => Http::response($this->getFixtureJson('tags-page-1.json')),
    ]);

    $response = Ghost::admin()->tags()
        ->limit(1)
        ->get();

    expectSuccessfulResponse($response, Tag::class);
    $tag = $response->data->first();

    if (!empty($tag->seo)) {
        expect($tag->seo)->toBeInstanceOf(Seo::class);
    }
});

it('returns a tag by ID', function () {
    $id = '5979a779df093500228e958b';
    Http::fake([
        "*admin/tags/$id/?*" => Http::response($this->getFixtureJson('tag.json')),
    ]);

    $ghost = Ghost::admin()->tags();
    $tag = $ghost->find($id);

    expectEndpointParameterSet($ghost, 'resourceId', $id);
    expect($tag)->toBeInstanceOf(Tag::class)
        ->toHaveProperty('id', $id);
});

it('returns a tag by slug', function () {
    $slug = 'fables';
    Http::fake([
        "*admin/tags/slug/$slug/?*" => Http::response($this->getFixtureJson('tags-page-1.json')),
    ]);

    $ghost = Ghost::admin()->tags();
    $tag = $ghost->fromSlug($slug);

    expectEndpointParameterSet($ghost, 'resourceSlug', $slug);
    expect($tag)->toBeInstanceOf(Tag::class)
        ->toHaveProperty('slug', $slug);
});

it('creates a tag', function () {
    Http::fake([
        "*admin/tags/?*" => Http::response($this->getFixtureJson('tag.json')),
    ]);

    $response = Ghost::admin()->tags()->create([
        'name' => 'My Test Tag',
        'status' => 'published',
    ]);

    expectSuccessfulResponse($response, Tag::class);

    $createdTag = $response->data->first();
    expect($createdTag)->toBeInstanceOf(Tag::class)
        ->toHaveProperty('id');
});

it('updates a tag', function () {
    $id = '6285dbba44c5d85187a074ba';

    Http::fake([
        "*admin/tags/$id/?*" => Http::response($this->getFixtureJson('tag.json')),
    ]);

    $tag = Ghost::admin()->tags()->find($id);
    $response = Ghost::admin()->tags()->update($id, [
        'title' => 'About this site updated',
        'updated_at' => $tag->updatedAt,
    ]);

    expectSuccessfulResponse($response, Tag::class);

    $createdTag = $response->data->first();
    expect($createdTag)->toBeInstanceOf(Tag::class)
        ->toHaveProperty('id');
});

it('deletes a tag', function () {
    $id = '6285dbba44c5d85187a074ba';

    //Delete requests have no payload in the request or response. Successful deletes will return an empty 204 response.
    Http::fake([
        "*admin/tags/$id/?*" => Http::response('', 204),
    ]);

    $response = Ghost::admin()->tags()->delete($id);

    expect($response)->toBeInstanceOf(SuccessResponse::class);
    expect($response->data)->toBeEmpty();
});
