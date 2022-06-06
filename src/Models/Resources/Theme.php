<?php

namespace Igorsgm\Ghost\Models\Resources;

/**
 * Class Theme
 *
 * @property-read mixed $name
 * @property-read mixed $package
 * @property-read boolean $active
 * @property-read array $templates
 */
class Theme extends BaseResource
{
    protected string $resourceName = 'themes';
}
