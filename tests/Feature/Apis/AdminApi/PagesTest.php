<?php

use Igorsgm\Ghost\Facades\Ghost;
use Igorsgm\Ghost\Models\Resources\Author;
use Igorsgm\Ghost\Models\Resources\Page;
use Igorsgm\Ghost\Models\Resources\Tag;
use Igorsgm\Ghost\Models\Seo;
use Igorsgm\Ghost\Responses\SuccessResponse;
use Illuminate\Support\Facades\Http;

uses()->group('admin');
uses()->group('pages');

it('sets resource to Page::class', function () {
    $ghost = Ghost::admin()->pages();
    expect($ghost->getResource())->toBeInstanceOf(Page::class);
});

it('gets all pages', function () {
    Http::fake([
        "*admin/pages*" => Http::response($this->getFixtureJson('pages-page-1.json')),
    ]);

    $response = Ghost::admin()->pages()->all();
    expectSuccessfulResponse($response, Page::class);
});

it('gets all pages paginated', function () {
    $limit = 2;
    Http::fake([
        "*admin/pages/?limit=$limit*" => Http::response($this->getFixtureJson('pages-page-2.json')),
    ]);
    $response = Ghost::admin()->pages()->paginate($limit);
    expectSuccessfulResponse($response, Page::class);
    expect($response->meta->pagination)->not()->toBeEmpty();
});

it('gets next paginated page', function () {

    $limit = 2;
    Http::fake([
        "*admin/pages/?limit=$limit&page=2*" => Http::response($this->getFixtureJson('pages-page-2.json')),
        "*admin/pages/?limit=$limit*" => Http::response($this->getFixtureJson('pages-page-1.json')),
    ]);

    $response = Ghost::admin()->pages()->paginate($limit);

    $meta = $response->meta;
    expect($meta->page())->toEqual(1);
    expect($meta->limit())->toEqual($limit);
    expect($meta->pages())->toBeGreaterThanOrEqual(1);
    expect($meta->total())->toBeGreaterThanOrEqual(1);
    expect($meta->hasNext())->toBeTrue();
    expect($meta->next())->toBeGreaterThanOrEqual(2);

    $nextPageResponse = $response->getNextPage();
    expectSuccessfulResponse($nextPageResponse, Page::class);
    expect($nextPageResponse->data->count())->toBeLessThanOrEqual($limit);
    expect($nextPageResponse->meta->pagination->page)->toEqual(2);
});

it('gets previous paginated page', function () {
    $limit = 2;
    Http::fake([
        "*admin/pages/?limit=$limit&page=1*" => Http::response($this->getFixtureJson('pages-page-1.json')),
        "*admin/pages/?limit=$limit&page=2*" => Http::response($this->getFixtureJson('pages-page-2.json')),
    ]);

    $response = Ghost::admin()->pages()->page(2)->paginate($limit);

    $meta = $response->meta;
    expect($meta->hasPrev())->toBeTrue();
    expect($meta->prev())->toEqual(1);

    $previousPageResponse = $response->getPreviousPage();

    expectSuccessfulResponse($previousPageResponse, Page::class);
    expect($previousPageResponse->data->count())->toBeLessThanOrEqual($limit);
    expect($previousPageResponse->meta->pagination->page)->toEqual(1);
});

it('parses properties to Author, Tag and Seo classes', function () {
    Http::fake([
        sprintf('*admin/pages/?include=%s*',
            urlencode('authors,tags')) => Http::response($this->getFixtureJson('pages-page-1.json')),
    ]);

    $response = Ghost::admin()->pages()
        ->include(['authors', 'tags'])
        ->limit(1)
        ->get();

    expectSuccessfulResponse($response, Page::class);
    $page = $response->data->first();

    expectCollectionToBeEmptyOrInstanceOf($page->authors, Author::class);
    expectCollectionToBeEmptyOrInstanceOf($page->tags, Tag::class);

    if (!empty($page->primaryAuthor)) {
        expect($page->primaryAuthor)->toBeInstanceOf(Author::class);
    }

    if (!empty($page->primaryTag)) {
        expect($page->primaryTag)->toBeInstanceOf(Tag::class);
    }

    if (!empty($page->seo)) {
        expect($page->seo)->toBeInstanceOf(Seo::class);
    }
});

it('returns a page by ID', function () {
    $id = '6285ed9644c5d85187a074ce';
    Http::fake([
        "*admin/pages/$id/?*" => Http::response($this->getFixtureJson('page.json')),
    ]);

    $ghost = Ghost::admin()->pages();
    $page = $ghost->find($id);

    expectEndpointParameterSet($ghost, 'resourceId', $id);
    expect($page)->toBeInstanceOf(Page::class)
        ->toHaveProperty('id', $id);
});

it('returns a page by slug', function () {
    $slug = 'about';
    Http::fake([
        "*admin/pages/slug/$slug/?*" => Http::response($this->getFixtureJson('pages-page-1.json')),
    ]);

    $ghost = Ghost::admin()->pages();
    $page = $ghost->fromSlug($slug);

    expectEndpointParameterSet($ghost, 'resourceSlug', $slug);
    expect($page)->toBeInstanceOf(Page::class)
        ->toHaveProperty('slug', $slug);
});

it('creates a page with mobiledoc source', function () {
    Http::fake([
        "*admin/pages/?*" => Http::response($this->getFixtureJson('page.json')),
    ]);

    $response = Ghost::admin()->pages()->create([
        'title' => 'My Test Page',
        'mobiledoc' => '{"version":"0.3.1","atoms":[],"cards":[],"markups":[],"sections":[[1,"p",[[0,[],0,"My page content. Work in progress..."]]]]}',
        'status' => 'published',
    ]);

    expectSuccessfulResponse($response, Page::class);

    $createdPage = $response->data->first();
    expect($createdPage)->toBeInstanceOf(Page::class)
        ->toHaveProperty('id');
});

it('creates a page with HTML source', function () {
    Http::fake([
        "*admin/pages/?*" => Http::response($this->getFixtureJson('page.json')),
    ]);

    $response = Ghost::admin()->pages()->source('html')->create([
        'title' => 'My Test Page 2',
        'html' => '<p>My page content. Work in progress...</p>',
        'status' => 'published',
    ]);

    expectSuccessfulResponse($response, Page::class);

    $createdPage = $response->data->first();
    expect($createdPage)->toBeInstanceOf(Page::class)
        ->toHaveProperty('id');
});

it('updates a page', function () {
    $id = '6285dbba44c5d85187a074ba';

    Http::fake([
        "*admin/pages/$id/?*" => Http::response($this->getFixtureJson('page.json')),
    ]);

    $page = Ghost::admin()->pages()->find($id);
    $response = Ghost::admin()->pages()->source('html')->update($id, [
        'title' => 'About this site updated',
        'updated_at' => $page->updatedAt,
    ]);

    expectSuccessfulResponse($response, Page::class);

    $createdPage = $response->data->first();
    expect($createdPage)->toBeInstanceOf(Page::class)
        ->toHaveProperty('id');
});

it('deletes a page', function () {
    $id = '6285dbba44c5d85187a074ba';

    //Delete requests have no payload in the request or response. Successful deletes will return an empty 204 response.
    Http::fake([
        "*admin/pages/$id/?*" => Http::response('', 204),
    ]);

    $response = Ghost::admin()->pages()->delete($id);

    expect($response)->toBeInstanceOf(SuccessResponse::class);
    expect($response->data)->toBeEmpty();
});
