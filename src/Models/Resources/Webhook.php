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
        return parent::fill(new self(), $array);
    }
}
