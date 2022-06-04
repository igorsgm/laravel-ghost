<?php

use Igorsgm\Ghost\Facades\Ghost;
use Igorsgm\Ghost\Models\Resources\Author;
use Igorsgm\Ghost\Models\Resources\Page;
use Igorsgm\Ghost\Models\Resources\Tag;
use Igorsgm\Ghost\Models\Seo;

uses()->group('content');
uses()->group('pages');

it('sets resource to Page::class', function () {
    $ghost = Ghost::content()->pages();
    expect($ghost->getResource())->toBeInstanceOf(Page::class);
});

it('gets all pages', function () {
    $response = Ghost::content()->pages()->all();
    expectSuccessfulResponse($response, Page::class);
});

it('gets all pages paginated', function () {
    $limit = 5;
    $response = Ghost::content()->pages()->paginate($limit);
    expectSuccessfulResponse($response, Page::class);
    expect($response->meta->pagination)->not()->toBeEmpty();
});

it('parses properties to Author, Tag and Seo classes', function () {
    $response = Ghost::content()->pages()
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
    $pageId = '62416b8cfb349a003cafc2f1';
    $ghost = Ghost::content()->pages();
    $page = $ghost->find($pageId);

    expectEndpointParameterSet($ghost, 'resourceId', $pageId);
    expect($page)->toBeInstanceOf(Page::class)
        ->toHaveProperty('id', $pageId);
});

it('returns first Page', function () {
    $page = Ghost::content()->pages()->first();
    expect($page)->toBeInstanceOf(Page::class);
});

it('returns a page by slug', function () {
    $slug = 'about';

    $ghost = Ghost::content()->pages();
    $page = $ghost->fromSlug($slug);

    expectEndpointParameterSet($ghost, 'resourceSlug', $slug);
    expect($page)->toBeInstanceOf(Page::class)
        ->toHaveProperty('slug', $slug);
});
