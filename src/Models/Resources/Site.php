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
        return parent::fill(new self(), $array);
    }
}
