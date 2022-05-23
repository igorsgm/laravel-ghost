<?php

namespace Igorsgm\Ghost\Models;

use Igorsgm\Ghost\Models\Resources\Offer;
use Igorsgm\Ghost\Models\Resources\Tier;

class Subscription
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
     * @return Navigation
     */
    public static function createFromArray($array): Subscription
    {
        $subscription = new self();

        $subscription->id = $array['id'] ?? null;
        $subscription->customer = $array['customer'] ?? null;
        $subscription->status = $array['status'] ?? null;
        $subscription->startDate = $array['start_date'] ?? null;
        $subscription->defaultPaymentCardLast4 = $array['default_payment_card_last4'] ?? null;

        $subscription->cancelAtPeriodEnd = $array['cancel_at_period_end'] ?? false;
        $subscription->cancellationReason = $array['cancellation_reason'] ?? null;

        $subscription->currentPeriodEnd = $array['current_period_end'] ?? null;

        $subscription->price = !empty($array['price']) ? Price::createFromArray($array['price']) : null;
        $subscription->tier = !empty($array['tier']) ? Tier::createFromArray($array['tier']) : null;
        $subscription->offer = !empty($array['offer']) ? Offer::createFromArray($array['offer']) : null;

        return $subscription;
    }
}
