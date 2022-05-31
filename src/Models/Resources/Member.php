<?php

namespace Igorsgm\Ghost\Models\Resources;

use Igorsgm\Ghost\Interfaces\ResourceInterface;

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
        return parent::fill(new self(), $array);
    }
}
