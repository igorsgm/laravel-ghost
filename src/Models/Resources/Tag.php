<?php

namespace Igorsgm\Ghost\Models\Resources;

use Igorsgm\Ghost\Interfaces\ResourceInterface;
use Igorsgm\Ghost\Models\Seo;

class Tag implements ResourceInterface
{
    /**
     * @var string|null
     */
    public $id;

    /**
     * @var string|null
     */
    public $slug;

    /**
     * @var string|null
     */
    public $name;

    /**
     * @var string|null
     */
    public $description;

    /**
     * @var string|null
     */
    public $featureImage;

    /**
     * @var string|null
     */
    public $visibility;

    /**
     * @var string|null
     */
    public $codeinjectionHead;

    /**
     * @var string|null
     */
    public $codeinjectionFoot;

    /**
     * @var string|null
     */
    public $accentColor;

    /**
     * @var string
     */
    public $url;

    /**
     * @var string|null
     */
    public $createdAt;

    /**
     * @var string|null
     */
    public $updatedAt;

    /**
     * Admin only
     * @var string|null
     */
    public $parent;

    /**
     * @var Seo
     */
    public $seo;

    /**
     * @var mixed
     */
    public $postsCount;

    /**
     * @param  array  $array
     * @return Tag
     */
    public static function createFromArray($array): Tag
    {
        $tag = new self();

        $tag->id = $array['id'] ?? null;
        $tag->name = $array['name'] ?? null;
        $tag->slug = $array['slug'] ?? null;
        $tag->description = $array['description'] ?? null;
        $tag->featureImage = $array['feature_image'] ?? null;
        $tag->visibility = $array['visibility'] ?? null;
        $tag->codeinjectionHead = $array['codeinjection_head'] ?? null;
        $tag->codeinjectionFoot = $array['codeinjection_foot'] ?? null;
        $tag->accentColor = $array['accent_color'] ?? null;
        $tag->parent = $array['parent'] ?? null;

        $tag->createdAt = $array['created_at'] ?? null;
        $tag->updatedAt = $array['updated_at'] ?? null;

        $tag->url = $array['url'] ?? null;
        $tag->seo = Seo::createFromArray($array);

        $tag->postsCount = data_get($array, 'count.posts');

        return $tag;
    }

    public function getResourceName()
    {
        return 'tags';
    }
}
