<?php

namespace Igorsgm\Ghost\Models\Resources;

/**
 * Class Offer
 * @property-read string $id
 * @property-read string $name Internal name for an offer, must be unique
 * @property-read string $code Shortcode for the offer, for example: https://yoursite.com/black-friday
 * @property-read string $displayTitle Name displayed in the offer window
 * @property-read boolean $displayDescription Text displayed in the offer window
 * @property-read string $type Percent or fixed - whether the amount off is a percentage or fixed
 * @property-read string $cadence month or year - denotes if offer applies to tier's monthly or yearly price
 * @property-read string $amount Offer discount amount, as a percentage or fixed value as set in type
 * @property-read string $duration once/forever/repeating. repeating duration is only available when cadence is month
 * @property-read string $durationInMonths Number of months offer should be repeated when duration is repeating
 * @property-read string $currencyRestriction Denotes whether the offer `currency` is restricted. If so, changing the currency invalidates the offer
 * @property-read string $currency Fixed type offers only - specifies tier's currency as three letter ISO currency code
 * @property-read mixed $status Active or archived - denotes if the offer is active or archived
 * @property-read mixed $redemptionCount Number of times the offer has been redeemed
 * @property-read Tier $tier Tier on which offer is applied
 * @property-read string $createdAt
 * @property-read string $updatedAt
 */
class Offer extends BaseResource
{
    protected string $resourceName = 'offers';
}
