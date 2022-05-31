<?php

namespace Igorsgm\Ghost\Models\Resources;

use Igorsgm\Ghost\Interfaces\ResourceInterface;

class Image extends BaseResource implements ResourceInterface
{
    protected string $resourceName = 'images';

    /**
     * URI The newly created URL for the image.
     * @var string|null
     */
    public $url;

    /**
     * String (optional) The reference for the image, if one was provided with the upload.
     * @var string|null
     */
    public $ref;

    /**
     * @param  array  $array
     * @return Image
     */
    public static function createFromArray($array): Image
    {
        return parent::fill(new self(), $array);
    }
}
