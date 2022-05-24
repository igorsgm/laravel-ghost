<?php

namespace Igorsgm\Ghost\Models\Resources;

use Igorsgm\Ghost\Interfaces\ResourceInterface;
use Igorsgm\Ghost\Models\Seo;

class Page extends BaseResource implements ResourceInterface
{
    protected string $resourceName = 'pages';

    /**
     * @var string
     */
    public $slug;

    /**
     * @var string
     */
    public $id;

    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $description;

    /**
     * @var string
     */
    public $featureImage;

    /**
     * @var string
     */
    public $visibility;

    /**
     * @var string
     */
    public $codeinjectionHead;

    /**
     * @var string
     */
    public $codeinjectionFoot;

    /**
     * @var string
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
     * @param  array  $array
     * @return Page
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
        $page->codeinjectionHead = $array['codeinjection_head'] ?? null;
        $page->codeinjectionFoot = $array['codeinjection_foot'] ?? null;
        $page->accentColor = $array['accent_color'] ?? null;

        $page->createdAt = $array['created_at'] ?? null;
        $page->updatedAt = $array['updated_at'] ?? null;

        $page->url = $array['url'] ?? null;

        $page->authors = collect(data_get($array, 'authors'))->map(function ($author) {
            return Author::createFromArray($author);
        });
        $page->primaryAuthor = !empty($array['primary_author']) ? Author::createFromArray($array['primary_author']) : null;

        $page->tags = collect(data_get($array, 'tags'))->map(function ($tag) {
            return Tag::createFromArray($tag);
        });
        $page->primaryTag = !empty($array['primary_tag']) ? Tag::createFromArray($array['primary_tag']) : null;

        $page->seo = Seo::createFromArray($array);

        return $page;
    }
}
