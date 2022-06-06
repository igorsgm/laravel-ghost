<?php

use Igorsgm\Ghost\Facades\Ghost;
use Igorsgm\Ghost\Models\Resources\Site;
use Illuminate\Support\Facades\Http;

uses()->group('admin');
uses()->group('site');

it('sets resource to Site::class', function () {
    $ghost = Ghost::admin()->site();
    expect($ghost->getResource())->toBeInstanceOf(Site::class);
});

it('gets site', function () {
    Http::fake([
        "*admin/site*" => Http::response($this->getFixtureJson('site.json')),
    ]);

    $response = Ghost::admin()->site()->get();
    $site = $response->data;
    expect($site)->toBeInstanceOf(Site::class);
});
