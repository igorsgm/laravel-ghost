<?php

use Igorsgm\Ghost\Facades\Ghost;
use Igorsgm\Ghost\Models\Resources\Theme;
use Igorsgm\Ghost\Responses\SuccessResponse;
use Illuminate\Support\Facades\Http;

uses()->group('admin');
uses()->group('themes');

it('sets resource to Theme::class', function () {
    $ghost = Ghost::admin()->themes();
    expect($ghost->getResource())->toBeInstanceOf(Theme::class);
});

it('uploads a theme', function () {
    Http::fake([
        '*admin/themes/upload*' => Http::response($this->getFixtureJson('themes.json')),
    ]);

    $zipPathOrUrl = 'https://www.learningcontainer.com/wp-content/uploads/2020/05/sample-zip-file.zip';
    $response = Ghost::admin()->themes()->upload($zipPathOrUrl);

    expect($response)->toBeInstanceOf(SuccessResponse::class);
    expectCollectionToBeEmptyOrInstanceOf($response->data, Theme::class);
});

it('activates a theme', function () {
    $themeName = 'foo';
    Http::fake([
        "*admin/themes/$themeName/activate*" => Http::response($this->getFixtureJson('themes.json')),
    ]);

    $response = Ghost::admin()->themes()->activate($themeName);

    expect($response)->toBeInstanceOf(SuccessResponse::class);
    expectCollectionToBeEmptyOrInstanceOf($response->data, Theme::class);
});
