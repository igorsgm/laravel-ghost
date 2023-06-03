<?php

use Igorsgm\Ghost\Facades\Ghost;
use Igorsgm\Ghost\Models\Resources\Tier;
use Illuminate\Support\Facades\Http;

uses()->group('content');
uses()->group('tiers');

it('sets resource to Tier::class', function () {
    $ghost = Ghost::content()->tiers();
    expect($ghost->getResource())->toBeInstanceOf(Tier::class);
});

it('gets all tiers', function () {
    $response = Ghost::content()->tiers()->all();
    expectSuccessfulResponse($response, Tier::class);
});

it('gets all tiers paginated', function () {
    $limit = 1;
    $response = Ghost::content()->tiers()->paginate($limit);
    expectSuccessfulResponse($response, Tier::class);
    expect($response->meta->pagination)->not()->toBeEmpty();
});

it('includes monthly_price and yearly_price', function () {
    Http::fake([
        '*tiers/?*' => Http::response($this->getFixtureJson('tier.json')),
    ]);

    $ghost = Ghost::content()->tiers()->include(['monthly_price', 'yearly_price']);
    expectQueryStringSet($ghost, 'include', 'monthly_price,yearly_price');

    $response = $ghost->limit(1)->get();
    expectSuccessfulResponse($response, Tier::class);

    $tier = $response->data->first();
    expect($tier)->toBeInstanceOf(Tier::class)
        ->toHaveProperties(['monthlyPrice', 'yearlyPrice']);
});
