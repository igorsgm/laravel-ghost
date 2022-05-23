<?php

namespace Igorsgm\Ghost\Models\Resources;

use Igorsgm\Ghost\Interfaces\ResourceInterface;
use Igorsgm\Ghost\Models\Label;
use Igorsgm\Ghost\Models\Subscription;

class Member extends BaseResource implements ResourceInterface
{
    protected string $resourceName = 'members';

    /**
     * @var string|null
     */
    public $id;

    /**
     * @var string|null
     */
    public $uuid;

    /**
     * @var string|null
     */
    public $email;

    /**
     * Member name
     * @var string|null
     */
    public $name;

    /**
     * Notes on the member
     * @var string|null
     */
    public $note;

    /**
     * @var string|null
     */
    public $geolocation;

    /**
     * Member’s newsletter subscription status
     * @var boolean
     */
    public $subscribed;

    /**
     * Member labels
     * @var \Illuminate\Support\Collection
     */
    public $labels;

    /**
     * @var array
     */
    public $subscriptions;

    /**
     * @var string|null
     */
    public $avatarImage;

    /**
     * @var integer
     */
    public $emailCount;

    /**
     * @var integer
     */
    public $emailOpenedCount;

    /**
     * @var string|null
     */
    public $emailOpenRate;

    /**
     * @var string|null
     */
    public $status;

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
     * @return Member
     */
    public static function createFromArray($array): Member
    {
        $member = new self();

        $member->id = $array['id'] ?? null;
        $member->uuid = $array['uuid'] ?? null;
        $member->email = $array['email'] ?? null;
        $member->name = $array['name'] ?? null;
        $member->note = $array['note'] ?? null;
        $member->geolocation = $array['geolocation'] ?? null;
        $member->subscribed = $array['subscribed'] ?? false;

        $member->labels = collect(data_get($array, 'labels'))->map(function ($tag) {
            return Label::createFromArray($tag);
        });

        $member->subscriptions = collect(data_get($array, 'subscriptions'))->map(function ($tag) {
            return Subscription::createFromArray($tag);
        });

        $member->avatarImage = $array['avatar_image'] ?? null;
        $member->emailCount = $array['email_count'] ?? 0;
        $member->emailOpenedCount = $array['email_opened_count'] ?? 0;
        $member->emailOpenRate = $array['email_open_rate'] ?? null;
        $member->status = $array['status'] ?? null;

        $member->createdAt = $array['created_at'] ?? null;
        $member->updatedAt = $array['updated_at'] ?? null;

        return $member;
    }
}
