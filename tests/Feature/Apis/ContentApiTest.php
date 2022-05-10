<?php

use Igorsgm\Ghost\Facades\Ghost;
use Igorsgm\Ghost\Responses\ErrorResponse;

it('returns ErrorResponse on slug not found for resources', function () {
    $resources = [
        'posts',
        'authors',
        'tags',
        'pages',
    ];

    foreach ($resources as $resource) {
        $ghost = Ghost::content()->$resource();
        $response = $ghost->fromSlug('random-slug');

        expect($response)->toBeInstanceOf(ErrorResponse::class);
    }
});
