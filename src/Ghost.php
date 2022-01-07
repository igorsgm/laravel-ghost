<?php

namespace Igorsgm\Ghost;

use Igorsgm\Ghost\Responses\PostsResponse;
use Illuminate\Support\Facades\Http;

class Ghost
{
    /**
     * @var string
     */
    public string $resource = "posts";

    /**
     * @var string
     */
    public string $resourceId = "";

    /**
     * @var string
     */
    public string $resourceSlug = "";

    /**
     * @var string
     */
    public string $includes = "";

    /**
     * @var string
     */
    public string $fields = "";

    /**
     * @var string
     */
    public string $formats = "";

    /**
     * @var string
     */
    public string $limit = "";

    /**
     * @var string
     */
    public string $page = "";

    /**
     * @var string
     */
    public string $order = "";

    /**
     * @var string
     */
    private string $key;

    /**
     * @var string
     */
    private string $domain;

    /**
     * @var string
     */
    private string $version;

    private string $responseType;

    /**
     * @param  string  $key
     * @param  string  $domain
     * @param  string  $version
     */
    public function __construct(string $key = '', string $domain = '', string $version = '')
    {
        $this->key = !empty($key) ? $key : config('ghost.key');
        $this->domain = !empty($domain) ? $domain : config('ghost.admin_domain');
        $this->version = !empty($version) ? $version : config('ghost.ghost_api_version');
    }

    /**
     * @return array[]
     */
    public function all(): array
    {
        return $this->limit('all')->get();
    }

    /**
     * @return array[]
     */
    public function get(): array
    {
        $response = Http::get($this->make());

        if (in_array($response->status(), [404, 422])) {
            return [];
        }

        $response = $response->json($this->resource);
        return new $this->responseType($response);
    }

    /**
     * @param $limit
     * @return array[]
     */
    public function paginate($limit = null): array
    {
        if (isset($limit)) {
            $this->limit = $limit;
        }

        $response = Http::get($this->make());

        if (in_array($response->status(), [404, 422])) {
            return ['posts' => []];
        }

        return $response->json();
    }

    /**
     * @return string
     */
    public function make(): string
    {
        return sprintf(
            "%s/ghost/api/v%s/content/%s/?%s",
            rtrim($this->domain, '/'),
            $this->version,
            $this->buildEndpoint(),
            $this->buildParams()
        );
    }

    /**
     * @return string
     */
    protected function buildEndpoint(): string
    {
        $endpoint = $this->resource;
        if (!empty($this->resourceId)) {
            $endpoint .= "/{$this->resourceId}";
        } elseif (!empty($this->resourceSlug)) {
            $endpoint .= "/slug/{$this->resourceSlug}";
        }

        return $endpoint;
    }

    /**
     * @return string
     */
    protected function buildParams(): string
    {
        $params = [
            'key' => $this->key,
            'include' => $this->includes ?: null,
            'fields' => $this->fields ?: null,
            'formats' => $this->formats ?: null,
            'limit' => $this->limit ?: null,
            'page' => $this->page ?: null,
            'order' => $this->order ?: null,
        ];

        return http_build_query($params);
    }

    /**
     * Limit how many records are returned at once
     *
     * @param  int|string  $limit
     *
     * @return $this
     */
    public function limit($limit): Ghost
    {
        $this->limit = strval($limit);

        return $this;
    }

    /**
     * @param  string  $resource
     * @return $this
     */
    public function setResource(string $resource): Ghost
    {
        $this->resource = $resource;

        return $this;
    }

    /**
     * @return $this
     */
    public function posts(): Ghost
    {
        $this->resource = 'posts';
        $this->responseType = PostsResponse::class;

        return $this;
    }

    /**
     * @return $this
     */
    public function authors(): Ghost
    {
        $this->resource = 'authors';

        return $this;
    }

    /**
     * @return $this
     */
    public function tags(): Ghost
    {
        $this->resource = 'tags';

        return $this;
    }

    /**
     * @return $this
     */
    public function pages(): Ghost
    {
        $this->resource = 'pages';

        return $this;
    }

    /**
     * @return $this
     */
    public function settings(): Ghost
    {
        $this->resource = 'settings';

        return $this;
    }

    /**
     * Return resource from ID
     *
     * @param  string  $id
     *
     * @return array
     */
    public function find(string $id)
    {
        $this->resourceId = $id;

        return $this->get()[0];
    }

    /**
     * Return resource from slug
     *
     * @param  string  $slug
     *
     * @return array
     */
    public function fromSlug(string $slug): array
    {
        $this->resourceSlug = $slug;

        return $this->get()[0] ?? [];
    }

    /**
     * Alias for Ghost's include
     * Possible includes: authors, tags, count.posts
     *
     * @param  string|array  ...$includes
     *
     * @return $this
     */
    public function include(...$includes): Ghost
    {
        $this->includes = collect($includes)->flatten()->implode(',');

        return $this;
    }

    /**
     * Limit the fields returned in the response object
     *
     * @param  string|array  ...$fields
     *
     * @return $this
     */
    public function fields(...$fields): Ghost
    {
        $this->fields = collect($fields)->flatten()->implode(',');

        return $this;
    }

    /**
     * Optionally request different format for posts and pages
     * Possible formats: html, plaintext
     *
     * @param  string  $format
     *
     * @return $this
     */
    public function format(string $format): Ghost
    {
        $this->formats = $format;

        return $this;
    }

    /**
     * @param  int  $page
     * @return $this
     */
    public function page(int $page): Ghost
    {
        $this->page = strval($page);

        return $this;
    }

    /**
     * @param  string  $attr
     * @param  string  $order
     * @return $this
     */
    public function orderBy(string $attr, string $order = "DESC"): Ghost
    {
        $this->order = $attr." ".strtolower($order);

        return $this;
    }
}
