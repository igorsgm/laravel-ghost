<?php

namespace Igorsgm\Ghost\Models;

use Igorsgm\Ghost\Models\Resources\Tag;
use Illuminate\Support\Str;

class Seo
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
        $seo = new self();

        $validProperties = [
            'og_image',
            'og_title',
            'og_description',
            'twitter_image',
            'twitter_title',
            'twitter_description',
            'meta_title',
            'meta_description',
            'canonical_url',
        ];

        foreach ($validProperties as $property) {
            $seo->{Str::camel($property)} = $array[$property] ?? null;
        }

        return $seo;
    }
}
