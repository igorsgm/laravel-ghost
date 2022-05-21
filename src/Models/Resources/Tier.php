<?php

namespace Igorsgm\Ghost\Models\Resources;

use Igorsgm\Ghost\Interfaces\ResourceInterface;
use Igorsgm\Ghost\Models\Benefit;
use Igorsgm\Ghost\Models\Price;

class Tier implements ResourceInterface
{
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
        $tier = new self();

        $tier->id = $array['id'] ?? null;
        $tier->name = $array['name'] ?? null;
        $tier->slug = $array['slug'] ?? null;
        $tier->description = $array['description'] ?? null;
        $tier->active = $array['active'] ?? false;
        $tier->type = $array['type'] ?? null;
        $tier->welcomePageUrl = $array['welcome_page_url'] ?? null;
        $tier->visibility = $array['visibility'] ?? null;

        $tier->stripePrices = !empty($array['stripe_prices']) ? Price::createFromArray($array['stripe_prices']) : null;
        $tier->monthlyPrice = !empty($array['monthly_price']) ? Price::createFromArray($array['monthly_price']) : null;
        $tier->yearlyPrice = !empty($array['yearly_price']) ? Price::createFromArray($array['yearly_price']) : null;

        $tier->benefits = collect(data_get($array, 'benefits'))->map(function ($benefit) {
            return Benefit::createFromArray($benefit);
        });

        $tier->createdAt = $array['created_at'] ?? null;
        $tier->updatedAt = $array['updated_at'] ?? null;

        return $tier;
    }

    public function getResourceName()
    {
        return 'tiers';
    }
}
