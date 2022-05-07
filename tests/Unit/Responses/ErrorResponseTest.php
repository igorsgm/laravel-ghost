<?php

use Igorsgm\Ghost\Facades\Ghost;
use Illuminate\Support\Collection;

it('sets success to false', function () {
    $response = Ghost::content()->posts()->find('foo-not-found');
    expect($response->success)->toBeFalse();
});

it('sets errors collection on debug enabled', function () {
    $this->config->set('ghost.debug.enabled', true);
    $response = Ghost::content()->posts()->find('foo-not-found');
    $errors = $response->errors;

    expect($errors)->toBeInstanceOf(Collection::class);
    expect($errors->count())->toBeGreaterThan(0);

    $firstError = $errors->first();
    expect($firstError)->toBeObject();
    expect($firstError->message)->not()->toBe($this->config->get('ghost.debug.default_error_message'));
});

it('sets default errors collection on debug disabled', function () {
    $this->config->set('ghost.debug.enabled', false);
    $response = Ghost::content()->posts()->find('foo-not-found');
    $errors = $response->errors;

    expect($errors)->toBeInstanceOf(Collection::class);
    expect($errors->count())->toEqual(1);

    $firstError = $errors->first();
    expect($firstError)->toBeObject();
    expect($firstError->message)->toBe($this->config->get('ghost.debug.default_error_message'));
});
