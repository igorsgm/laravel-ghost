<?php

namespace Igorsgm\Ghost\Apis;

use Igorsgm\Ghost\Models\Resources\Author;
use Igorsgm\Ghost\Models\Resources\Page;
use Igorsgm\Ghost\Models\Resources\Post;
use Igorsgm\Ghost\Models\Resources\Settings;
use Igorsgm\Ghost\Models\Resources\Tag;
use Igorsgm\Ghost\Responses\ErrorResponse;
use Igorsgm\Ghost\Responses\SuccessResponse;
use Illuminate\Support\Facades\Http;

class ContentApi extends BaseApi
{
    /**
     * @param  array  $params  Here you can provide 'key', 'domain', 'version' to override the default ones.
     */
    public function __construct(array $params = [])
    {
        $this->key = data_get($params, 'key') ?? config('ghost.content_key');
        $this->domain = data_get($params, 'domain') ?? config('ghost.admin_domain');
        $this->version = data_get($params, 'version') ?? config('ghost.ghost_api_version');
        $this->baseUrl = sprintf("%s/ghost/api/v%s/content", rtrim($this->domain, '/'), $this->version);
    }

    /**
     * @return SuccessResponse|ErrorResponse
     */
    public function get()
    {
        $response = Http::get($this->makeApiUrl());
        return $this->handleResponse($response);
    }

    /**
     * @return $this
     */
    public function posts(): ContentApi
    {
        return $this->setResource(Post::class);
    }

    /**
     * @return $this
     */
    public function authors(): ContentApi
    {
        return $this->setResource(Author::class);
    }

    /**
     * @return $this
     */
    public function tags(): ContentApi
    {
        return $this->setResource(Tag::class);
    }

    /**
     * @return $this
     */
    public function pages(): ContentApi
    {
        return $this->setResource(Page::class);
    }

    /**
     * @return $this
     */
    public function settings(): ContentApi
    {
        return $this->setResource(Settings::class);
    }
}
