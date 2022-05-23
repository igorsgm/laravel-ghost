<?php

namespace Igorsgm\Ghost\Models\Resources;

use Igorsgm\Ghost\Interfaces\ResourceInterface;

class Site extends BaseResource implements ResourceInterface
{
    protected string $resourceName = 'site';

    /**
     * @var string|null
     */
    public $title;

    /**
     * @var string|null
     */
    public $description;

    /**
     * @var string|null
     */
    public $logo;

    /**
     * @var string|null
     */
    public $url;

    /**
     * @var string|null
     */
    public $version;

    /**
     * @param  array  $array
     * @return Site
     */
    public static function createFromArray($array): Site
    {
        $site = new self();

        $site->title = $array['title'] ?? null;
        $site->description = $array['description'] ?? null;
        $site->logo = $array['logo'] ?? null;
        $site->url = $array['url'] ?? null;
        $site->version = $array['version'] ?? null;

        return $site;
    }
}
