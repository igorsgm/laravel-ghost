<?php

namespace Igorsgm\Ghost\Models;

class Tag
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

        $tag->slug = $array['slug'] ?? null;
        $tag->id = $array['id'] ?? null;
        $tag->name = $array['name'] ?? null;
        $tag->description = $array['description'] ?? null;
        $tag->featureImage = $array['feature_image'] ?? null;
        $tag->visibility = $array['visibility'] ?? null;
        $tag->codeinjectionHead = $array['codeinjection_head'] ?? null;
        $tag->codeinjectionFoot = $array['codeinjection_foot'] ?? null;
        $tag->accentColor = $array['accent_color'] ?? null;

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
