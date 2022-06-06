<?php

namespace Igorsgm\Ghost\Models\Resources;

use Igorsgm\Ghost\Models\BaseModel;

abstract class BaseResource extends BaseModel
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
