<?php

namespace Igorsgm\Ghost\Models;

use Igorsgm\Ghost\Models\Resources\Offer;
use Igorsgm\Ghost\Models\Resources\Tier;

class Subscription extends BaseModel
{
    /**
     * @var mixed|null
     */
    public $id;

    /**
     * Stripe customer attached to the subscription
     * @var mixed|null
     */
    public $customer;

    /**
     * @var mixed|null
     */
    public $status;

    /**
     * Subscription start date
     * @var mixed|null
     */
    public $startDate;

    /**
     * Last 4 digits of the card
     * @var mixed|null
     */
    public $defaultPaymentCardLast4;

    /**
     * If the subscription should be canceled or renewed at period end
     * @var false|mixed
     */
    public $cancelAtPeriodEnd;

    /**
     * Reason for subscription cancellation
     * @var mixed|null
     */
    public $cancellationReason;

    /**
     * Subscription end date
     * @var mixed|null
     */
    public $currentPeriodEnd;

    /**
     * Price information for subscription including Stripe price ID
     * @var Price|null
     */
    public ?Price $price;

    /**
     * Member subscription tier
     * @var Tier|null
     */
    public ?Tier $tier;

    /**
     * Offer details for a subscription
     * @var Offer|null
     */
    public ?Offer $offer;

    /**
     * @param  array  $array
     * @return Subscription
     */
    public static function createFromArray($array): Subscription
    {
        return parent::fill(new self(), $array);
    }
}
