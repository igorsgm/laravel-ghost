<?php

use Igorsgm\Ghost\Facades\Ghost;
use Igorsgm\Ghost\Models\Resources\Webhook;
use Igorsgm\Ghost\Responses\SuccessResponse;
use Illuminate\Support\Facades\Http;

uses()->group('admin');
uses()->group('webhooks');

it('sets resource to Webhook::class', function () {
    $ghost = Ghost::admin()->webhooks();
    expect($ghost->getResource())->toBeInstanceOf(Webhook::class);
});

it('creates a webhook', function () {
    Http::fake([
        "*admin/webhooks/?*" => Http::response($this->getFixtureJson('webhooks.json')),
    ]);

    $response = Ghost::admin()->webhooks()->create([
        'event' => 'post.added',
        'target_url' => 'https://example.com/hook/',
        'integration_id' => '5c739b7c8a59a6c8ddc164a1',
    ]);

    expectSuccessfulResponse($response, Webhook::class);

    $createdWebhook = $response->data->first();
    expect($createdWebhook)->toBeInstanceOf(Webhook::class)
        ->toHaveProperty('id');
});

it('updates a webhook', function () {
    $id = '5f04028cc9b839282b0eb5e3';

    Http::fake([
        "*admin/webhooks/$id/?*" => Http::response($this->getFixtureJson('webhooks.json')),
    ]);

    $response = Ghost::admin()->webhooks()->update($id, [
        'event' => 'post.published.edited',
        'name' => 'Webhook example',
    ]);

    expectSuccessfulResponse($response, Webhook::class);

    $createdWebhook = $response->data->first();
    expect($createdWebhook)->toBeInstanceOf(Webhook::class)
        ->toHaveProperty('id');
});

it('deletes a webhook', function () {
    $id = '5f04028cc9b839282b0eb5e3';

    Http::fake([
        "*admin/webhooks/$id/?*" => Http::response('', 204),
    ]);

    $response = Ghost::admin()->webhooks()->delete($id);

    expect($response)->toBeInstanceOf(SuccessResponse::class);
    expect($response->data)->toBeEmpty();
});
