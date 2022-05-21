<?php

namespace Igorsgm\Ghost\Models\Resources;

use Igorsgm\Ghost\Interfaces\ResourceInterface;

class Offer implements ResourceInterface
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
    public $code;

    /**
     * @var string|null
     */
    public $displayTitle;

    /**
     * @var boolean
     */
    public $displayDescription;

    /**
     * @var string|null
     */
    public $type;

    /**
     * @var string|null
     */
    public $cadence;

    /**
     * @var string|null
     */
    public $amount;

    /**
     * @var array
     */
    public $duration;

    /**
     * @var string|null
     */
    public $createdAt;

    /**
     * @var string|null
     */
    public $updatedAt;

    /**
     * @var string|null
     */
    public $durationInMonths;

    /**
     * @var string|null
     */
    public $currencyRestriction;

    /**
     * @var string|null
     */
    public $currency;

    /**
     * @var mixed|null
     */
    public $status;

    /**
     * @var mixed|null
     */
    public $redemptionCount;

    /**
     * @var Tier|null
     */
    public ?Tier $tier;

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

    public function getResourceName()
    {
        return 'offers';
    }
}
