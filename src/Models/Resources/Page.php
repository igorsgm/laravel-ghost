<?php

namespace Igorsgm\Ghost\Models\Resources;

use Igorsgm\Ghost\Interfaces\ResourceInterface;
use Igorsgm\Ghost\Models\Seo;

class Page implements ResourceInterface
{
    /**
     * @var string
     */
    public $slug;

    /**
     * @varstring
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
        $page->codeinjectionHead = $array['codeinjection_head'] ?? null;
        $page->codeinjectionFoot = $array['codeinjection_foot'] ?? null;
        $page->accentColor = $array['accent_color'] ?? null;

        $page->url = $array['url'] ?? null;
        $page->seo = Seo::createFromArray($array);

        return $page;
    }

    public function getResourceName()
    {
        return 'pages';
    }
}
