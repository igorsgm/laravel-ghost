<?php

namespace Igorsgm\Ghost\Apis;

use Igorsgm\Ghost\Models\Resources\Author;
use Igorsgm\Ghost\Models\Resources\Page;
use Igorsgm\Ghost\Models\Resources\Post;
use Igorsgm\Ghost\Models\Resources\Settings;
use Igorsgm\Ghost\Models\Resources\Tag;
use Igorsgm\Ghost\Models\Resources\Tier;
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
     * Posts are the primary resource in a Ghost site.
     * Using the posts' endpoint it is possible to get lists of posts filtered by various criteria.
     * By default, posts are returned in reverse chronological order by published date when fetching more than one.
     *
     * @return ContentApi
     * @see https://ghost.org/docs/content-api/#posts
     */
    public function posts(): ContentApi
    {
        return $this->setResource(Post::class);
    }

    /**
     * Pages are static resources that are not included in channels or collections on the Ghost front-end.
     * The API will only return pages that were created as resources
     * and will not contain routes created with dynamic routing.
     *
     * @return ContentApi
     * @see https://ghost.org/docs/content-api/#pages
     */
    public function pages(): ContentApi
    {
        return $this->setResource(Page::class);
    }

    /**
     * Tags are the primary taxonomy within a Ghost site.
     *
     * @see https://ghost.org/docs/content-api/#tags
     * @return ContentApi
     */
    public function tags(): ContentApi
    {
        return $this->setResource(Tag::class);
    }

    /**
     * Authors are a subset of users who have published posts associated with them.
     *
     * @see https://ghost.org/docs/content-api/#authors
     * @return ContentApi
     */
    public function authors(): ContentApi
    {
        return $this->setResource(Author::class);
    }

    /**
     * Settings contain the global settings for a site.
     *
     * @see https://ghost.org/docs/content-api/#settings
     * @return ContentApi
     */
    public function settings(): ContentApi
    {
        return $this->setResource(Settings::class);
    }

    /**
     * Tiers allow publishers to create multiple options for an audience to become paid subscribers.
     * Each tier can have its own price points, benefits, and content access levels.
     * Ghost connects tiers directly to the publication’s Stripe account.
     *
     * @see https://ghost.org/docs/content-api/#tiers
     * @return ContentApi
     */
    public function tiers(): ContentApi
    {
        return $this->setResource(Tier::class);
    }
}
