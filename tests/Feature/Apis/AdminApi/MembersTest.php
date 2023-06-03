<?php

use Igorsgm\Ghost\Facades\Ghost;
use Igorsgm\Ghost\Models\Label;
use Igorsgm\Ghost\Models\Resources\Member;
use Igorsgm\Ghost\Models\Subscription;
use Illuminate\Support\Facades\Http;

uses()->group('admin');
uses()->group('members');

it('sets resource to Member::class', function () {
    $ghost = Ghost::admin()->members();
    expect($ghost->getResource())->toBeInstanceOf(Member::class);
});

it('gets all members', function () {
    Http::fake([
        '*admin/members*' => Http::response($this->getFixtureJson('members.json')),
    ]);

    $response = Ghost::admin()->members()->all();
    expectSuccessfulResponse($response, Member::class);
});

it('parses properties to Label and Subscription classes', function () {
    Http::fake([
        '*admin/members/?*' => Http::response($this->getFixtureJson('members.json')),
    ]);

    $response = Ghost::admin()->members()
        ->limit(1)
        ->get();

    expectSuccessfulResponse($response, Member::class);
    $member = $response->data->first();

    if (! empty($member->labels)) {
        expectCollectionToBeEmptyOrInstanceOf($member->labels, Label::class);
    }

    if (! empty($member->subscriptions)) {
        expectCollectionToBeEmptyOrInstanceOf($member->subscriptions, Subscription::class);
    }
});

it('returns a member by ID', function () {
    $id = '623199bfe8bc4d3097caefe0';
    Http::fake([
        "*admin/members/$id/?*" => Http::response($this->getFixtureJson('members.json')),
    ]);

    $ghost = Ghost::admin()->members();
    $member = $ghost->find($id);

    expectEndpointParameterSet($ghost, 'resourceId', $id);
    expect($member)->toBeInstanceOf(Member::class)
        ->toHaveProperty('id', $id);
});

it('creates a member', function () {
    Http::fake([
        '*admin/members/?*' => Http::response($this->getFixtureJson('members.json')),
    ]);

    $response = Ghost::admin()->members()->create([
        'email' => 'jamie@ghost.org',
        'name' => 'Jamie',
        'note' => 'notes on the member',
        'subscribed' => 'free',
    ]);

    expectSuccessfulResponse($response, Member::class);

    $createdMember = $response->data->first();
    expect($createdMember)->toBeInstanceOf(Member::class)
        ->toHaveProperty('id');
});

it('updates a member', function () {
    $id = '623199bfe8bc4d3097caefe0';

    Http::fake([
        "*admin/members/$id/?*" => Http::response($this->getFixtureJson('members.json')),
    ]);

    $response = Ghost::admin()->members()->update($id, [
        'name' => 'Jamie 2',
    ]);

    expectSuccessfulResponse($response, Member::class);

    $createdMember = $response->data->first();
    expect($createdMember)->toBeInstanceOf(Member::class)
        ->toHaveProperty('id');
});
