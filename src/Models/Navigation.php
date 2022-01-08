<?php

namespace Igorsgm\Ghost\Models;

class Navigation
{
    /**
     * @var string|null
     */
    public $label;

    /**
     * @var string|null
     */
    public $url;

    /**
     * @param  array  $array
     * @return Navigation
     */
    public static function createFromArray($array): Navigation
    {
        $navigation = new self();

        $navigation->label = $array['label'] ?? null;
        $navigation->url = $array['url'] ?? null;

        return $navigation;
    }
}
