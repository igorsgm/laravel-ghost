<?php

namespace Igorsgm\Ghost\Models;

class Seo extends BaseModel
{
    /**
     * @var string
     */
    public $ogImage;

    /**
     * @var string
     */
    public $ogTitle;

    /**
     * @var string
     */
    public $ogDescription;

    /**
     * @var string
     */
    public $twitterImage;

    /**
     * @var string
     */
    public $twitterTitle;

    /**
     * @var string
     */
    public $twitterDescription;

    /**
     * @var string
     */
    public $metaTitle;

    /**
     * @var string
     */
    public $metaDescription;

    /**
     * @var string
     */
    public $canonicalUrl;

    /**
     * @param  array  $array
     * @return Seo
     */
    public static function createFromArray($array): Seo
    {
        return parent::fill(new self(), $array);
    }
}
