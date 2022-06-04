<?php

namespace Igorsgm\Ghost\Models\Resources;

/**
 * Class Site
 *
 * @property-read string $title
 * @property-read string $description
 * @property-read string $logo
 * @property-read string $url
 * @property-read string $version
 */
class Site extends BaseResource
{
    protected string $resourceName = 'site';
}
