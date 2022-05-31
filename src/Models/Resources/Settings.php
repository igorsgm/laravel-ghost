<?php

namespace Igorsgm\Ghost\Models\Resources;

use Igorsgm\Ghost\Interfaces\ResourceInterface;

class Settings extends BaseResource implements ResourceInterface
{
    protected string $resourceName = 'settings';

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
    public $icon;

    /**
     * @var string|null
     */
    public $accentColor;

    /**
     * @var string|null
     */
    public $coverImage;

    /**
     * @var string|null
     */
    public $facebook;

    /**
     * @var string|null
     */
    public $twitter;

    /**
     * @var string|null
     */
    public $lang;

    /**
     * @var string|null
     */
    public $timezone;

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
    public $navigation;

    /**
     * @var string|null
     */
    public $secondaryNavigation;

    /**
     * @var string|null
     */
    public $membersSupportAddress;

    /**
     * @var string|null
     */
    public $url;


    /**
     * @param  array  $array
     * @return Settings
     */
    public static function createFromArray($array): Settings
    {
        return parent::fill(new self(), $array);
    }
}
