<?php

use Igorsgm\Ghost\Facades\Ghost;
use Igorsgm\Ghost\Models\Resources\Image;
use Igorsgm\Ghost\Responses\SuccessResponse;
use Illuminate\Support\Facades\Http;

uses()->group('admin');
uses()->group('images');

it('sets resource to Image::class', function () {
    $ghost = Ghost::admin()->images();
    expect($ghost->getResource())->toBeInstanceOf(Image::class);
});

it('uploads an image', function () {
    Http::fake([
        '*admin/images/upload*' => Http::response($this->getFixtureJson('images.json'), 201),
    ]);

    $imagePathOrUrl = 'https://picsum.photos/200';
    $response = Ghost::admin()->images()->upload($imagePathOrUrl);

    expect($response)->toBeInstanceOf(SuccessResponse::class);
    expectCollectionToBeEmptyOrInstanceOf($response->data, Image::class);
});
