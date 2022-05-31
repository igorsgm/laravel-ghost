<?php

namespace Igorsgm\Ghost\Models\Resources;

use Igorsgm\Ghost\Interfaces\ResourceInterface;
use Igorsgm\Ghost\Models\Price;

class Tier extends BaseResource implements ResourceInterface
{
    protected string $resourceName = 'tiers';

    /**
     * @var string|null
     */
    public $id;

    /**
     * @var string|null
     */
    public $name;

    /**
     * @var string|null
     */
    public $slug;

    /**
     * @var string|null
     */
    public $description;

    /**
     * @var boolean
     */
    public $active;

    /**
     * @var string|null
     */
    public $type;

    /**
     * @var string|null
     */
    public $welcomePageUrl;

    /**
     * @var string|null
     */
    public $visibility;

    /**
     * @var array
     */
    public $benefits;

    /**
     * @var string|null
     */
    public $createdAt;

    /**
     * @var string|null
     */
    public $updatedAt;

    /**
     * @var \Igorsgm\Ghost\Models\Navigation|Price|null
     */
    public $stripePrices;

    /**
     * @var \Igorsgm\Ghost\Models\Navigation|Price|null
     */
    public $monthlyPrice;
    /**
     * @var \Igorsgm\Ghost\Models\Navigation|Price|null
     */
    public $yearlyPrice;

    /**
     * @param  array  $array
     * @return Tier
     */
    public static function createFromArray($array): Tier
    {
        return parent::fill(new self(), $array);
    }
}
