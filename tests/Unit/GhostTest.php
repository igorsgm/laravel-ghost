<?php

use Igorsgm\Ghost\Apis\AdminApi;
use Igorsgm\Ghost\Apis\ContentApi;
use Igorsgm\Ghost\Facades\Ghost;

it('returns ContentApi on content()', function () {
    $api = Ghost::content();
    expect($api)->toBeInstanceOf(ContentApi::class);
});

it('returns AdminApi on admin()', function () {
    $api = Ghost::admin();
    expect($api)->toBeInstanceOf(AdminApi::class);
});
