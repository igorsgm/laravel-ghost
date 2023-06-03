<?php

namespace Igorsgm\Ghost\Models\Resources;

/**
 * Class Tag
 *
 * @property-read string $id
 * @property-read string $slug
 * @property-read string $name
 * @property-read string $description
 * @property-read string $featureImage
 * @property-read string $visibility
 * @property-read string $codeinjectionHead
 * @property-read string $codeinjectionFoot
 * @property-read string $accentColor
 * @property-read string $url
 * @property-read string $parent Admin only
 * @property-read \Igorsgm\Ghost\Models\Seo $seo
 * @property-read mixed $postsCount
 * @property-read string $createdAt
 * @property-read string $updatedAt
 */
class Tag extends BaseResource
{
    protected string $resourceName = 'tags';

    public function __construct(array $data = [])
    {
        parent::__construct($data);
        $this->postsCount = data_get($data, 'count.posts');
    }
}
