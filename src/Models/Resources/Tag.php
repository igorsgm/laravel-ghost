<?php

namespace Igorsgm\Ghost\Models\Resources;

use Igorsgm\Ghost\Interfaces\ResourceInterface;
use Igorsgm\Ghost\Models\Seo;

class Tag extends BaseResource implements ResourceInterface
{
    protected string $resourceName = 'tags';

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
        return parent::fill(new self(), $array);
    }
}
