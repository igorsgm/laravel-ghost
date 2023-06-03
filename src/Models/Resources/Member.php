<?php

namespace Igorsgm\Ghost\Models\Resources;

/**
 * Class Member
 *
 * @property-read string $id;
 * @property-read string $uuid;
 * @property-read string $email;
 * @property-read string $name Member name;
 * @property-read string $note Notes on the member;
 * @property-read string $geolocation;
 * @property-read bool $subscribed Member’s newsletter subscription status;
 * @property-read \Illuminate\Support\Collection $labels Member labels;
 * @property-read array $subscriptions;
 * @property-read string $avatarImage;
 * @property-read int $emailCount;
 * @property-read int $emailOpenedCount;
 * @property-read string $emailOpenRate;
 * @property-read string $status;
 * @property-read string $createdAt;
 * @property-read string $updatedAt
 */
class Member extends BaseResource
{
    protected string $resourceName = 'members';
}
