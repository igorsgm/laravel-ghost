<?php

namespace Igorsgm\Ghost\Apis;

use Igorsgm\Ghost\Interfaces\ResourceInterface;
use Igorsgm\Ghost\Responses\ErrorResponse;
use Igorsgm\Ghost\Responses\SuccessResponse;
use Illuminate\Support\Collection;

abstract class BaseApi
{
    /**
     * @var string
     */
    protected $baseUrl;

    /**
     * @var ResourceInterface
     */
    protected $resource;

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
    public string $include = "";

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
    protected $source = "";

    /**
     * @var string
     */
    public string $limit = "";

    /**
     * @var string
     */
    public string $filter = "";

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
    protected string $key;

    /**
     * @var string
     */
    protected string $domain;

    /**
     * @var string
     */
    protected string $version;

    /**
     * @return string
     */
    protected function buildEndpoint(): string
    {
        $endpoint = $this->resource->getResourceName();

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
    protected function makeApiUrl($suffix = ''): string
    {
        return sprintf("%s/%s/?%s", $this->baseUrl, $this->buildEndpoint().$suffix, $this->buildParams());
    }

    /**
     * @return string
     */
    protected function buildParams(): string
    {
        $params = [
            'include' => $this->include ?: null,
            'fields' => $this->fields ?: null,
            'formats' => $this->formats ?: null,
            'source' => $this->source ?: null,
            'filter' => $this->filter ?: null,
            'limit' => $this->limit ?: null,
            'page' => $this->page ?: null,
            'order' => $this->order ?: null,
            'key' => $this->key,
        ];

        return http_build_query($params);
    }

    /**
     * @param $response
     * @return ErrorResponse|SuccessResponse
     */
    protected function handleResponse($response)
    {
        if ($response->failed()) {
            return new ErrorResponse($response);
        }

        return new SuccessResponse($this, $this->resource, $response);
    }

    /**
     * Return resource from slug
     *
     * @param  string  $slug
     *
     * @return array|ErrorResponse|mixed
     */
    public function fromSlug(string $slug)
    {
        $this->resourceSlug = $slug;
        $response = $this->get();

        if ($response instanceof ErrorResponse) {
            return $response;
        }

        return data_get($response->data, 0, []);
    }

    /**
     * @return Collection|array[]
     */
    public function all()
    {
        return $this->limit('all')->get();
    }

    /**
     * @param $limit
     * @return array[]
     */
    public function paginate($limit = null)
    {
        if (isset($limit)) {
            $this->limit = $limit;
        }

        return $this->get();
    }

    /**
     * Return resource from ID
     *
     * @param  string  $id
     *
     * @return ResourceInterface|ErrorResponse
     */
    public function find(string $id)
    {
        $this->resourceId = $id;
        $response = $this->get();

        if ($response instanceof ErrorResponse) {
            return $response;
        }

        return data_get($response->data, 0, []);
    }

    /**
     * Apply fine-grained filters to target specific data.
     *
     * @param  string  $filter
     *
     * @return $this
     * @see https://ghost.org/docs/content-api/#filtering
     * @see https://gist.github.com/ErisDS/f516a859355d515aa6ad
     */
    public function filter($filter): BaseApi
    {
        $this->filter = $filter;

        return $this;
    }

    /**
     * Limit how many records are returned at once
     *
     * @param  int|string  $limit
     *
     * @return $this
     * @see https://ghost.org/docs/content-api/#limit
     */
    public function limit($limit): BaseApi
    {
        $this->limit = strval($limit);

        return $this;
    }

    /**
     * @param  string  $resourceClass
     * @return $this
     */
    public function setResource(string $resourceClass): BaseApi
    {
        $this->resource = resolve($resourceClass);

        return $this;
    }

    /**
     * @return ResourceInterface
     */
    public function getResource()
    {
        return $this->resource;
    }

    /**
     * Alias for Ghost's include.
     *
     * The following includes are available:
     * Posts & Pages: authors, tags
     * Authors: count.posts
     * Tags: count.posts
     * Tiers: monthly_price, yearly_price, benefits
     *
     * @param  string|array  ...$includes
     * @return $this
     * @see https://ghost.org/docs/content-api/#include
     *
     */
    public function include(...$includes): BaseApi
    {
        $this->include = collect($includes)->flatten()->implode(',');

        return $this;
    }

    /**
     * Alias for include method
     *
     * @param ...$includes
     * @return $this
     */
    public function with(...$includes): BaseApi
    {
        return $this->include(...$includes);
    }

    /**
     * Limit the fields returned in the response object
     *
     * @param  string|array  ...$fields
     *
     * @return $this
     * @see https://ghost.org/docs/content-api/#fields
     */
    public function fields(...$fields): BaseApi
    {
        $this->fields = collect($fields)->flatten()->implode(',');

        return $this;
    }

    /**
     * Optionally request different format for posts and pages
     * By default, Admin API expects and returns content in the mobiledoc format only.
     * To include html in the response use this parameter.
     *
     * Possible formats: html, plaintext, mobiledoc.
     *
     *
     * @param  string  $format
     *
     * @return $this
     */
    public function formats(string $format): BaseApi
    {
        $this->formats = $format;

        return $this;
    }

    /**
     * @param  int  $page
     * @return $this
     * @see https://ghost.org/docs/content-api/#page
     */
    public function page(int $page): BaseApi
    {
        $this->page = strval($page);

        return $this;
    }

    /**
     * @param  string  $attr
     * @param  string  $order
     *
     * @return $this
     * @see https://ghost.org/docs/content-api/#order
     */
    public function order(string $attr, string $order = "DESC"): ContentApi
    {
        $this->order = $attr." ".strtolower($order);

        return $this;
    }

    /**
     * Alias for order method
     *
     * @param  string  $attr
     * @param  string  $order
     * @return $this
     */
    public function orderBy(string $attr, string $order = "DESC"): ContentApi
    {
        return $this->order($attr, $order);
    }
}
