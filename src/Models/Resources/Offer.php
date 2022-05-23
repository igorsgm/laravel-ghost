<?php

namespace Igorsgm\Ghost\Models\Resources;

use Igorsgm\Ghost\Interfaces\ResourceInterface;

class Offer extends BaseResource implements ResourceInterface
{
    protected string $resourceName = 'offers';

    /**
     * @var string|null
     */
    public $id;

    /**
     * Internal name for an offer, must be unique
     *
     * @var string|null
     */
    public $name;

    /**
     * Shortcode for the offer, for example: https://yoursite.com/black-friday
     *
     * @var string|null
     */
    public $code;

    /**
     * Name displayed in the offer window
     *
     * @var string|null
     */
    public $displayTitle;

    /**
     * Text displayed in the offer window
     *
     * @var boolean
     */
    public $displayDescription;

    /**
     * Percent or fixed - whether the amount off is a percentage or fixed
     * @var string|null
     */
    public $type;

    /**
     * month or year - denotes if offer applies to tier's monthly or yearly price
     * @var string|null
     */
    public $cadence;

    /**
     * Offer discount amount, as a percentage or fixed value as set in type.
     * Amount is always denoted by the smallest currency unit (e.g., 100 cents instead of $1.00 in USD)
     * @var string|null
     */
    public $amount;

    /**
     * once/forever/repeating. repeating duration is only available when cadence is month
     *
     * @var string|null
     */
    public $duration;

    /**
     * Number of months offer should be repeated when duration is repeating
     *
     * @var string|null
     */
    public $durationInMonths;

    /**
     * Denotes whether the offer `currency` is restricted. If so, changing the currency invalidates the offer
     * @var string|null
     */
    public $currencyRestriction;

    /**
     * Fixed type offers only - specifies tier's currency as three letter ISO currency code
     *
     * @var string|null
     */
    public $currency;

    /**
     * Active or archived - denotes if the offer is active or archived
     *
     * @var mixed|null
     */
    public $status;

    /**
     * Number of times the offer has been redeemed
     *
     * @var mixed|null
     */
    public $redemptionCount;

    /**
     * Tier on which offer is applied
     * @var Tier|null
     */
    public ?Tier $tier;

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
     * @return Offer
     */
    public static function createFromArray($array): Offer
    {
        $offer = new self();

        $offer->id = $array['id'] ?? null;
        $offer->name = $array['name'] ?? null;
        $offer->code = $array['code'] ?? null;
        $offer->displayTitle = $array['display_title'] ?? null;
        $offer->displayDescription = $array['display_description'] ?? false;
        $offer->type = $array['type'] ?? null;
        $offer->cadence = $array['cadence'] ?? null;
        $offer->amount = $array['amount'] ?? null;
        $offer->duration = $array['duration'] ?? [];

        $offer->durationInMonths = $array['duration_in_months'] ?? null;
        $offer->currencyRestriction = $array['currency_restriction'] ?? null;
        $offer->currency = $array['currency'] ?? null;
        $offer->status = $array['status'] ?? null;
        $offer->redemptionCount = $array['redemption_count'] ?? null;
        $offer->tier = !empty($array['tier']) ? Tier::createFromArray($array['tier']) : null;

        $offer->createdAt = $array['created_at'] ?? null;
        $offer->updatedAt = $array['updated_at'] ?? null;

        return $offer;
    }
}
