<?php

namespace Igorsgm\Ghost\Models\Resources;

/**
 * Class Tier
 *
 * @property-read string $id
 * @property-read string $name
 * @property-read string $slug
 * @property-read string $description
 * @property-read bool $active
 * @property-read string $type
 * @property-read string $welcomePageUrl
 * @property-read string $visibility
 * @property-read array $benefits
 * @property-read \Igorsgm\Ghost\Models\Navigation|\Igorsgm\Ghost\Models\Price $stripePrices
 * @property-read \Igorsgm\Ghost\Models\Navigation|\Igorsgm\Ghost\Models\Price $monthlyPrice
 * @property-read \Igorsgm\Ghost\Models\Navigation|\Igorsgm\Ghost\Models\Price $yearlyPrice
 * @property-read string $createdAt
 * @property-read string $updatedAt
 */
class Tier extends BaseResource
{
    protected string $resourceName = 'tiers';
}
