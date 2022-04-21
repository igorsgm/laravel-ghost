<?php

namespace Igorsgm\Ghost\Models\Resources;

use Igorsgm\Ghost\Interfaces\ResourceInterface;
use Igorsgm\Ghost\Models\Navigation;
use Igorsgm\Ghost\Models\Seo;

class Settings implements ResourceInterface
{
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
        $settings = new self();

        $settings->title = $array['title'] ?? null;
        $settings->description = $array['description'] ?? null;
        $settings->logo = $array['logo'] ?? null;
        $settings->icon = $array['icon'] ?? null;
        $settings->accentColor = $array['accent_color'] ?? null;
        $settings->coverImage = $array['cover_image'] ?? null;
        $settings->facebook = $array['facebook'] ?? null;
        $settings->twitter = $array['twitter'] ?? null;
        $settings->lang = $array['lang'] ?? null;
        $settings->timezone = $array['timezone'] ?? null;
        $settings->codeinjectionHead = $array['codeinjection_head'] ?? null;
        $settings->codeinjectionFoot = $array['codeinjection_foot'] ?? null;
        $settings->navigation = collect(data_get($array, 'navigation'))->map(function ($navigation) {
            return Navigation::createFromArray($navigation);
        });
        $settings->secondaryNavigation = $array['secondary_navigation'] ?? null;
        $settings->membersSupportAddress = $array['members_support_address'] ?? null;

        $settings->url = $array['url'] ?? null;
        $settings->seo = Seo::createFromArray($array);

        return $settings;
    }

    public function getResourceName()
    {
        return 'settings';
    }
}
