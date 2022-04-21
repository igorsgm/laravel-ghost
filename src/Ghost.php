<?php

namespace Igorsgm\Ghost;

use Igorsgm\Ghost\Apis\AdminApi;
use Igorsgm\Ghost\Apis\ContentApi;

class Ghost
{
    /**
     * @param  array  $params
     * @return ContentApi|\Illuminate\Contracts\Foundation\Application|mixed
     */
    public function content(array $params = []): ContentApi
    {
        return resolve(ContentApi::class, compact('params'));
    }

    /**
     * @param  array  $params
     * @return AdminApi
     */
    public function admin(array $params = []): AdminApi
    {
        return resolve(AdminApi::class, compact('params'));
    }
}
