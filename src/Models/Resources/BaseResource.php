<?php

namespace Igorsgm\Ghost\Models\Resources;

abstract class BaseResource
{
    /**
     * The API Resource name on Ghost API
     * @var string
     */
    protected string $resourceName = '';

    /**
     * @return string
     */
    public function getResourceName()
    {
        return $this->resourceName;
    }
}
