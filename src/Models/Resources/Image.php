<?php

namespace Igorsgm\Ghost\Models\Resources;

/**
 * Class Image
 *
 * @property-read string $url URI The newly created URL for the image;
 * @property-read string $ref String (optional) The reference for the image, if one was provided with the upload.;
 */
class Image extends BaseResource
{
    protected string $resourceName = 'images';
}
