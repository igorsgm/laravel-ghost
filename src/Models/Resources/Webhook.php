<?php

namespace Igorsgm\Ghost\Models\Resources;

/**
 * Class Webhook
 *
 * @property-read string $id
 * @property-read string $event
 * @property-read string $targetUrl
 * @property-read string $name
 * @property-read string $secret
 * @property-read string $apiVersion
 * @property-read string $integrationId
 * @property-read string $status
 * @property-read string $lastTriggeredAt
 * @property-read string $lastTriggeredStatus
 * @property-read string $lastTriggeredError
 * @property-read string $createdAt
 * @property-read string $updatedAt
 */
class Webhook extends BaseResource
{
    protected string $resourceName = 'webhooks';
}
