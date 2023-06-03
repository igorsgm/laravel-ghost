<?php

use Igorsgm\Ghost\Facades\Ghost;
use Igorsgm\Ghost\Models\Navigation;
use Igorsgm\Ghost\Models\Resources\Settings;
use Igorsgm\Ghost\Models\Seo;
use Igorsgm\Ghost\Responses\SuccessResponse;

uses()->group('content');
uses()->group('settings');

it('sets resource to Settings::class', function () {
    $ghost = Ghost::content()->settings();
    expect($ghost->getResource())->toBeInstanceOf(Settings::class);
});

it('gets all settings', function () {
    $response = Ghost::content()->settings()->all();
    expect($response)->toBeInstanceOf(SuccessResponse::class);

    $settings = $response->data;
    expect($settings)->toBeInstanceOf(Settings::class);
});

it('parses properties to Navigation and Seo classes', function () {
    $response = Ghost::content()->settings()->limit(1)->get();
    $settings = $response->data;

    expectCollectionToBeEmptyOrInstanceOf($settings->navigation, Navigation::class);

    if (! empty($post->seo)) {
        expect($post->seo)->toBeInstanceOf(Seo::class);
    }
});
