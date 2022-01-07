<?php

namespace Igorsgm\Ghost\Models;

class Tag
{
    /**
     * @var string|null
     */
    public $slug;

    /**
     * @var string|null
     */
    public $id;

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
    public $metaTitle;

    /**
     * @var string|null
     */
    public $metaDescription;

    /**
     * @var string|null
     */
    public $ogImage;

    /**
     * @var string|null
     */
    public $ogTitle;

    /**
     * @var string|null
     */
    public $ogDescription;

    /**
     * @var string|null
     */
    public $twitterImage;

    /**
     * @var string|null
     */
    public $twitterTitle;

    /**
     * @var string|null
     */
    public $twitterDescription;

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
    public $canonicalUrl;

    /**
     * @var string|null
     */
    public $accentColor;

    /**
     * @var string|null
     */
    public $url;

    /**
     * @param array $array
     * @return Tag
     */
    public static function createFromArray($array): Tag
    {
        $tag = new self();

        $tag->id = $array['id'] ?? null;
        $tag->slug = $array['slug'] ?? null;
        $tag->name = $array['name'] ?? null;
        $tag->description = $array['description'] ?? null;
        $tag->featureImage = $array['feature_image'] ?? null;
        $tag->visibility = $array['visibility'] ?? null;
        $tag->metaTitle = $array['meta_title'] ?? null;
        $tag->metaDescription = $array['meta_description'] ?? null;
        $tag->ogImage = $array['og_image'] ?? null;
        $tag->ogTitle = $array['og_title'] ?? null;
        $tag->ogDescription = $array['og_description'] ?? null;
        $tag->twitterImage = $array['twitter_image'] ?? null;
        $tag->twitterTitle = $array['twitter_title'] ?? null;
        $tag->twitterDescription = $array['twitter_description'] ?? null;
        $tag->codeinjectionHead = $array['codeinjection_head'] ?? null;
        $tag->codeinjectionFoot = $array['codeinjection_foot'] ?? null;
        $tag->canonicalUrl = $array['canonical_url'] ?? null;
        $tag->accentColor = $array['accent_color'] ?? null;
        $tag->url = $array['url'] ?? null;

        return $tag;
    }
}
