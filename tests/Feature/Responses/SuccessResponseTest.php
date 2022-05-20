<?php

use Igorsgm\Ghost\Facades\Ghost;
use Igorsgm\Ghost\Models\Resources\Post;

it('gets next paginated page', function () {
    $limit = 5;
    $response = Ghost::content()->posts()->paginate($limit);

    expect($response->meta->hasNext())->toBeTrue();

    $nextPageResponse = $response->getNextPage();
    expectSuccessfulResponse($nextPageResponse, Post::class);
    expect($nextPageResponse->data->count())->toBeLessThanOrEqual($limit);
    expect($nextPageResponse->meta->pagination->page)->toEqual(2);
});

it('gets previous paginated page', function () {
    $limit = 5;
    $response = Ghost::content()->posts()->page(2)->paginate($limit);

    expect($response->meta->hasPrev())->toBeTrue();

    $previousPageResponse = $response->getPreviousPage();

    expectSuccessfulResponse($previousPageResponse, Post::class);
    expect($previousPageResponse->data->count())->toBeLessThanOrEqual($limit);
    expect($previousPageResponse->meta->pagination->page)->toEqual(1);
});
