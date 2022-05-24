<?php

namespace Igorsgm\Ghost\Models\Resources;

use Igorsgm\Ghost\Interfaces\ResourceInterface;

class Webhook extends BaseResource implements ResourceInterface
{
    protected string $resourceName = 'webhooks';

    /**
     * @var string|null
     */
    public $id;

    /**
     * @var string|null
     */
    public $event;

    /**
     * @var string|null
     */
    public $targetUrl;

    /**
     * @var string|null
     */
    public $name;

    /**
     * @var string|null
     */
    public $secret;

    /**
     * @var string|null
     */
    public $apiVersion;

    /**
     * @var string|null
     */
    public $integrationId;

    /**
     * @var string|null
     */
    public $status;

    /**
     * @var string|null
     */
    public $lastTriggeredAt;

    /**
     * @var string|null
     */
    public $lastTriggeredStatus;

    /**
     * @var string|null
     */
    public $lastTriggeredError;

    /**
     * @var string|null
     */
    public $createdAt;

    /**
     * @var string|null
     */
    public $updatedAt;

    /**
     * @param  array  $array
     * @return Webhook
     */
    public static function createFromArray($array): Webhook
    {
        $webhook = new self();

        $webhook->id = $array['id'] ?? null;
        $webhook->event = $array['event'] ?? null;
        $webhook->targetUrl = $array['target_url'] ?? null;
        $webhook->name = $array['name'] ?? null;
        $webhook->secret = $array['secret'] ?? null;
        $webhook->apiVersion = $array['api_version'] ?? null;
        $webhook->integrationId = $array['integration_id'] ?? null;
        $webhook->status = $array['status'] ?? null;
        $webhook->lastTriggeredAt = $array['last_triggered_at'] ?? null;
        $webhook->lastTriggeredStatus = $array['last_triggered_status'] ?? null;
        $webhook->lastTriggeredError = $array['last_triggered_error'] ?? null;

        $webhook->createdAt = $array['created_at'] ?? null;
        $webhook->updatedAt = $array['updated_at'] ?? null;

        return $webhook;
    }
}
