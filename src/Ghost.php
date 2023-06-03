<?php

namespace Igorsgm\Ghost;

use Igorsgm\Ghost\Apis\AdminApi;
use Igorsgm\Ghost\Apis\ContentApi;

class Ghost
{
    /**
     * @return ContentApi|\Illuminate\Contracts\Foundation\Application|mixed
     */
    public function content(array $params = []): ContentApi
    {
        return resolve(ContentApi::class, compact('params'));
    }

    public function admin(array $params = []): AdminApi
    {
        return resolve(AdminApi::class, compact('params'));
    }
}
