<?php

namespace Igorsgm\Ghost\Models\Resources;

/**
 * Class Page
 *
 * @property-read string $slug
 * @property-read string $id
 * @property-read string $name
 * @property-read string $description
 * @property-read string $featureImage
 * @property-read string $visibility
 * @property-read string $codeinjectionHead
 * @property-read string $codeinjectionFoot
 * @property-read string $accentColor
 * @property-read string $url
 * @property-read \Illuminate\Support\Collection $authors
 * @property-read Author $primaryAuthor
 * @property-read \Illuminate\Support\Collection $tags
 * @property-read Tag $primaryTag
 * @property-read \Igorsgm\Ghost\Models\Seo $seo
 * @property-read string $createdAt
 * @property-read string $updatedAt
 */
class Page extends BaseResource
{
    protected string $resourceName = 'pages';
}
