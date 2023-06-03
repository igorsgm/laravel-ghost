<?php

use Igorsgm\Ghost\Facades\Ghost;
use Igorsgm\Ghost\Models\Resources\User;
use Illuminate\Support\Facades\Http;

uses()->group('admin');
uses()->group('users');

it('sets resource to User::class', function () {
    $ghost = Ghost::admin()->users();
    expect($ghost->getResource())->toBeInstanceOf(User::class);
});

it('gets all users', function () {
    Http::fake([
        '*admin/users*' => Http::response($this->getFixtureJson('users.json')),
    ]);

    $response = Ghost::admin()->users()->all();
    expectSuccessfulResponse($response, User::class);
});

it('returns a user by ID', function () {
    $id = '5951f5fca366002ebd5dbef7';
    Http::fake([
        "*admin/users/$id/?*" => Http::response($this->getFixtureJson('users.json')),
    ]);

    $ghost = Ghost::admin()->users();
    $user = $ghost->find($id);

    expectEndpointParameterSet($ghost, 'resourceId', $id);
    expect($user)->toBeInstanceOf(User::class)
        ->toHaveProperty('id', $id);
});
