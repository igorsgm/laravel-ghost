<?php

use Igorsgm\Ghost\Facades\Ghost;
use Igorsgm\Ghost\Models\Resources\Offer;
use Igorsgm\Ghost\Models\Resources\Tier;
use Illuminate\Support\Facades\Http;

uses()->group('admin');
uses()->group('offers');

it('sets resource to Offer::class', function () {
    $ghost = Ghost::admin()->offers();
    expect($ghost->getResource())->toBeInstanceOf(Offer::class);
});

it('gets all offers', function () {
    Http::fake([
        '*admin/offers*' => Http::response($this->getFixtureJson('offers.json')),
    ]);

    $response = Ghost::admin()->offers()->all();
    expectSuccessfulResponse($response, Offer::class);
});

it('parses property to Tier classes', function () {
    Http::fake([
        '*admin/offers/?*' => Http::response($this->getFixtureJson('offers.json')),
    ]);

    $response = Ghost::admin()->offers()
        ->limit(1)
        ->get();

    expectSuccessfulResponse($response, Offer::class);
    $offer = $response->data->first();

    if (! empty($offer->tier)) {
        expect($offer->tier)->toBeInstanceOf(Tier::class);
    }
});

it('returns an offer by ID', function () {
    $id = '6230dd69e8bc4d3097caefd3';
    Http::fake([
        "*admin/offers/$id/?*" => Http::response($this->getFixtureJson('offers.json')),
    ]);

    $ghost = Ghost::admin()->offers();
    $offer = $ghost->find($id);

    expectEndpointParameterSet($ghost, 'resourceId', $id);
    expect($offer)->toBeInstanceOf(Offer::class)
        ->toHaveProperty('id', $id);
});

it('creates an offer', function () {
    Http::fake([
        '*admin/offers/?*' => Http::response($this->getFixtureJson('offers.json')),
    ]);

    $response = Ghost::admin()->offers()->create([
        'name' => 'Black Friday',
        'code' => 'black-friday',
        'display_title' => 'Black Friday Sale!',
        'display_description' => '10% off on yearly plan',
    ]);

    expectSuccessfulResponse($response, Offer::class);

    $createdOffer = $response->data->first();
    expect($createdOffer)->toBeInstanceOf(Offer::class)
        ->toHaveProperty('id');
});

it('updates an offer', function () {
    $id = '6285dbba44c5d85187a074ba';

    Http::fake([
        "*admin/offers/$id/?*" => Http::response($this->getFixtureJson('offers.json')),
    ]);

    $response = Ghost::admin()->offers()->update($id, [
        'display_title' => 'Black Friday 2022',
        'code' => 'black-friday-2022',
    ]);

    expectSuccessfulResponse($response, Offer::class);

    $createdOffer = $response->data->first();
    expect($createdOffer)->toBeInstanceOf(Offer::class)
        ->toHaveProperty('id');
});
