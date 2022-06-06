<?php

namespace Igorsgm\Ghost\Models;

use Igorsgm\Ghost\Models\Resources\Offer;
use Igorsgm\Ghost\Models\Resources\Tier;

/**
 * Class Subscription
 *
 * @property-read mixed $id
 * @property-read mixed $customer Stripe customer attached to the subscription
 * @property-read mixed $status
 * @property-read mixed $startDate Subscription start date
 * @property-read mixed $defaultPaymentCardLast4 Last 4 digits of the card
 * @property-read false|mixed $cancelAtPeriodEnd If the subscription should be canceled or renewed at period end
 * @property-read mixed $cancellationReason Reason for subscription cancellation
 * @property-read mixed $currentPeriodEnd Subscription end date
 * @property-read Price $price Price information for subscription including Stripe price ID
 * @property-read Tier $tier Member subscription tier
 * @property-read Offer $offer Offer details for a subscription
 */
class Subscription extends BaseModel
{
}
