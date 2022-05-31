<?php

namespace Igorsgm\Ghost\Models\Resources;

use Igorsgm\Ghost\Interfaces\ResourceInterface;
use Igorsgm\Ghost\Models\Seo;
use Illuminate\Support\Collection;

class Post extends BaseResource implements ResourceInterface
{
    protected string $resourceName = 'posts';

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
    public $uuid;

    /**
     * @var string|null
     */
    public $title;

    /**
     * @var string|null
     */
    public $mobiledoc;

    /**
     * @var string|null
     */
    public $html;

    /**
     * @var string|null
     */
    public $commentId;

    /**
     * @var string|null
     */
    public $featureImage;

    /**
     * @var string|null
     */
    public $featureImageAlt;

    /**
     * @var string|null
     */
    public $featureImageCaption;

    /**
     * @var string|null
     */
    public $featured;

    /**
     * @var string|null
     */
    public $visibility;

    /**
     * @var string|null
     */
    public $createdAt;

    /**
     * @var string|null
     */
    public $updatedAt;

    /**
     * @var string|null
     */
    public $publishedAt;

    /**
     * @var string|null
     */
    public $customExcerpt;

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
    public $customTemplate;

    /**
     * @var string|null
     */
    public $emailRecipientFilter;

    /**
     * @var string|null
     */
    public $url;

    /**
     * @var string|null
     */
    public $excerpt;

    /**
     * @var string|null
     */
    public $readingTime;

    /**
     * @var string|null
     */
    public $access;

    /**
     * @var string|null
     */
    public $emailSubject;

    /**
     * @var boolean
     */
    public $emailOnly;

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
     * @param  array  $array
     * @return Post
     */
    public static function createFromArray($array): Post
    {
        return parent::fill(new self(), $array);
    }
}
