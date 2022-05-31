<?php

namespace Igorsgm\Ghost\Models\Resources;

use Igorsgm\Ghost\Interfaces\ResourceInterface;
use Igorsgm\Ghost\Models\Seo;
use Illuminate\Support\Collection;

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
     * @var Collection|null
     */
    public $authors;

    /**
     * @var Author|null
     */
    public $primaryAuthor;

    /**
     * @var Collection|null
     */
    public $tags;

    /**
     * @var Tag|null
     */
    public $primaryTag;

    /**
     * @var Seo
     */
    public $seo;

    /**
     * @var string|null
     */
    public $createdAt;

    /**
     * @var string|null
     */
    public $updatedAt;

    /**
     * @param  array  $array
     * @return Page
     */
    public static function createFromArray($array): Page
    {
        return parent::fill(new self(), $array);
    }
}
