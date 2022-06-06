<?php

namespace Igorsgm\Ghost\Models\Resources;

/**
 * Class Settings
 *
 * @property-read string $title
 * @property-read string $description
 * @property-read string $logo
 * @property-read string $icon
 * @property-read string $accentColor
 * @property-read string $coverImage
 * @property-read string $facebook
 * @property-read string $twitter
 * @property-read string $lang
 * @property-read string $timezone
 * @property-read string $codeinjectionHead
 * @property-read string $codeinjectionFoot
 * @property-read string $navigation
 * @property-read string $secondaryNavigation
 * @property-read string $membersSupportAddress
 * @property-read string $url
 */
class Settings extends BaseResource
{
    protected string $resourceName = 'settings';
}
