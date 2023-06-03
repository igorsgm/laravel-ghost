<?php

namespace Igorsgm\Ghost\Models\Resources;

/**
 * Class Theme
 *
 * @property-read mixed $name
 * @property-read mixed $package
 * @property-read bool $active
 * @property-read array $templates
 */
class Theme extends BaseResource
{
    protected string $resourceName = 'themes';
}
