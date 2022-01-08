<?php

namespace Igorsgm\Ghost\Models;

class Page
{
    public $slug;
    public $id;
    public $name;
    public $description;
    public $featureImage;
    public $visibility;
    public $metaTitle;
    public $metaDescription;
    public $ogImage;
    public $ogTitle;
    public $ogDescription;
    public $twitterImage;
    public $twitterTitle;
    public $twitterDescription;
    public $codeinjectionHead;
    public $codeinjectionFoot;
    public $canonicalUrl;
    public $accentColor;
    public $url;

    /**
     * @param  array  $array
     * @return Tag
     */
    public static function createFromArray($array): Page
    {
        $page = new self();

        $page->slug = $array['slug'] ?? null;
        $page->id = $array['id'] ?? null;
        $page->name = $array['name'] ?? null;
        $page->description = $array['description'] ?? null;
        $page->featureImage = $array['feature_image'] ?? null;
        $page->visibility = $array['visibility'] ?? null;
        $page->metaTitle = $array['meta_title'] ?? null;
        $page->metaDescription = $array['meta_description'] ?? null;
        $page->ogImage = $array['og_image'] ?? null;
        $page->ogTitle = $array['og_title'] ?? null;
        $page->ogDescription = $array['og_description'] ?? null;
        $page->twitterImage = $array['twitter_image'] ?? null;
        $page->twitterTitle = $array['twitter_title'] ?? null;
        $page->twitterDescription = $array['twitter_description'] ?? null;
        $page->codeinjectionHead = $array['codeinjection_head'] ?? null;
        $page->codeinjectionFoot = $array['codeinjection_foot'] ?? null;
        $page->canonicalUrl = $array['canonical_url'] ?? null;
        $page->accentColor = $array['accent_color'] ?? null;
        $page->url = $array['url'] ?? null;

        return $page;
    }

    public function getResourceName()
    {
        return 'pages';
    }
}
