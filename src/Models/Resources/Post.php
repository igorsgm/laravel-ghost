<?php

namespace Igorsgm\Ghost\Models\Resources;

/**
 * Class Post
 *
 * @property-read string $id
 * @property-read string $slug
 * @property-read string $uuid
 * @property-read string $title
 * @property-read string $mobiledoc
 * @property-read string $html
 * @property-read string $commentId
 * @property-read string $featureImage
 * @property-read string $featureImageAlt
 * @property-read string $featureImageCaption
 * @property-read string $featured
 * @property-read string $visibility
 * @property-read string $createdAt
 * @property-read string $updatedAt
 * @property-read string $publishedAt
 * @property-read string $customExcerpt
 * @property-read string $codeinjectionHead
 * @property-read string $codeinjectionFoot
 * @property-read string $customTemplate
 * @property-read string $emailRecipientFilter
 * @property-read string $url
 * @property-read string $excerpt
 * @property-read string $readingTime
 * @property-read string $access
 * @property-read string $emailSubject
 * @property-read bool $emailOnly
 * @property-read \Illuminate\Support\Collection $authors
 * @property-read Author $primaryAuthor
 * @property-read \Illuminate\Support\Collection $tags
 * @property-read Tag $primaryTag
 * @property-read \Igorsgm\Ghost\Models\Seo $seo
 */
class Post extends BaseResource
{
    protected string $resourceName = 'posts';
}
