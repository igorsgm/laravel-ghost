<?php

use Igorsgm\Ghost\Facades\Ghost;
use Igorsgm\Ghost\Models\Benefit;
use Igorsgm\Ghost\Models\Price;
use Igorsgm\Ghost\Models\Resources\Tier;
use Igorsgm\Ghost\Responses\SuccessResponse;
use Illuminate\Support\Facades\Http;

uses()->group('admin');
uses()->group('tiers');

it('sets resource to Tier::class', function () {
    $ghost = Ghost::admin()->tiers();
    expect($ghost->getResource())->toBeInstanceOf(Tier::class);
});

it('gets all tiers', function () {
    Http::fake([
        "*admin/tiers*" => Http::response($this->getFixtureJson('tiers.json')),
    ]);

    $response = Ghost::admin()->tiers()->all();
    expectSuccessfulResponse($response, Tier::class);
});

it('gets all tiers paginated', function () {
    $limit = 2;
    Http::fake([
        "*admin/tiers/?limit=$limit*" => Http::response($this->getFixtureJson('tiers-page-2.json')),
    ]);
    $response = Ghost::admin()->tiers()->paginate($limit);
    expectSuccessfulResponse($response, Tier::class);
    expect($response->meta->pagination)->not()->toBeEmpty();
});

it('gets next paginated tier', function () {

    $limit = 2;
    Http::fake([
        "*admin/tiers/?limit=$limit&page=2*" => Http::response($this->getFixtureJson('tiers-page-2.json')),
        "*admin/tiers/?limit=$limit*" => Http::response($this->getFixtureJson('tiers.json')),
    ]);

    $response = Ghost::admin()->tiers()->paginate($limit);

    $meta = $response->meta;
    expect($meta->page())->toEqual(1);
    expect($meta->limit())->toEqual($limit);
    expect($meta->pages())->toBeGreaterThanOrEqual(1);
    expect($meta->total())->toBeGreaterThanOrEqual(1);
    expect($meta->hasNext())->toBeTrue();
    expect($meta->next())->toBeGreaterThanOrEqual(2);

    $nextPageResponse = $response->getNextPage();
    expectSuccessfulResponse($nextPageResponse, Tier::class);
    expect($nextPageResponse->data->count())->toBeLessThanOrEqual($limit);
    expect($nextPageResponse->meta->pagination->page)->toEqual(2);
});

it('gets previous paginated tier', function () {
    $limit = 2;
    Http::fake([
        "*admin/tiers/?limit=$limit&page=1*" => Http::response($this->getFixtureJson('tiers.json')),
        "*admin/tiers/?limit=$limit&page=2*" => Http::response($this->getFixtureJson('tiers-page-2.json')),
    ]);

    $response = Ghost::admin()->tiers()->page(2)->paginate($limit);

    $meta = $response->meta;
    expect($meta->hasPrev())->toBeTrue();
    expect($meta->prev())->toEqual(1);

    $previousTierResponse = $response->getPreviousPage();

    expectSuccessfulResponse($previousTierResponse, Tier::class);
    expect($previousTierResponse->data->count())->toBeLessThanOrEqual($limit);
    expect($previousTierResponse->meta->pagination->page)->toEqual(1);
});

it('parses properties to Benefit and Price classes', function () {
    Http::fake([
        '*admin/tiers/?*' => Http::response($this->getFixtureJson('tiers.json')),
    ]);

    $response = Ghost::admin()->tiers()
        ->limit(1)
        ->get();

    expectSuccessfulResponse($response, Tier::class);
    $tier = $response->data->first();

    if (!empty($tier->benefits)) {
        expectCollectionToBeEmptyOrInstanceOf($tier->benefits, Benefit::class);
    }

    if (!empty($tier->monthlyPrice)) {
        expect($tier->monthlyPrice)->toBeInstanceOf(Price::class);
    }

    if (!empty($tier->yearlyPrice)) {
        expect($tier->yearlyPrice)->toBeInstanceOf(Price::class);
    }

    if (!empty($tier->stripePrices)) {
        expectCollectionToBeEmptyOrInstanceOf($tier->stripePrices, Price::class);
    }
});

it('returns a tier by ID', function () {
    $id = '622727ad96a190e914ab6664';
    Http::fake([
        "*admin/tiers/$id/?*" => Http::response($this->getFixtureJson('tier.json')),
    ]);

    $ghost = Ghost::admin()->tiers();
    $tier = $ghost->find($id);

    expectEndpointParameterSet($ghost, 'resourceId', $id);
    expect($tier)->toBeInstanceOf(Tier::class)
        ->toHaveProperty('id', $id);
});

it('returns a tier by slug', function () {
    $slug = 'free';
    Http::fake([
        "*admin/tiers/slug/$slug/?*" => Http::response($this->getFixtureJson('tiers.json')),
    ]);

    $ghost = Ghost::admin()->tiers();
    $tier = $ghost->fromSlug($slug);

    expectEndpointParameterSet($ghost, 'resourceSlug', $slug);
    expect($tier)->toBeInstanceOf(Tier::class)
        ->toHaveProperty('slug', $slug);
});

it('creates a tier', function () {
    Http::fake([
        "*admin/tiers/?*" => Http::response($this->getFixtureJson('tier.json')),
    ]);

    $response = Ghost::admin()->tiers()->create([
        'name' => 'Platinum',
        'description' => 'Access to everything',
        'welcome_page_url' => '/welcome-to-platinum',
        'visibility' => 'public',
        'monthly_price' => [],
        'yearly_price' => [],
        'benefits' => [
            [], []
        ],
    ]);

    expectSuccessfulResponse($response, Tier::class);

    $createdTier = $response->data->first();
    expect($createdTier)->toBeInstanceOf(Tier::class)
        ->toHaveProperty('id');
});

it('updates a tier', function () {
    $id = '6285dbba44c5d85187a074ba';

    Http::fake([
        "*admin/tiers/$id/?*" => Http::response($this->getFixtureJson('tier.json')),
    ]);

    $response = Ghost::admin()->tiers()->update($id, [
        'name' => 'Platinum 2',
        'description' => 'Plat',
    ]);

    expectSuccessfulResponse($response, Tier::class);

    $createdTier = $response->data->first();
    expect($createdTier)->toBeInstanceOf(Tier::class)
        ->toHaveProperty('id');
});
