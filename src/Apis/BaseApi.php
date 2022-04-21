<?php

namespace Igorsgm\Ghost\Apis;

use Igorsgm\Ghost\Interfaces\ResourceInterface;
use Igorsgm\Ghost\Responses\ErrorResponse;
use Igorsgm\Ghost\Responses\SuccessResponse;
use Illuminate\Support\Collection;

class BaseApi
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
    protected $source = "";

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
    protected function makeApiUrl(): string
    {
        return sprintf("%s/%s/?%s", $this->baseUrl, $this->buildEndpoint(), $this->buildParams());
    }

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
    protected function buildParams(): string
    {
        $params = [
            'key' => $this->key,
            'include' => $this->includes ?: null,
            'fields' => $this->fields ?: null,
            'formats' => $this->formats ?: null,
            'source' => $this->source ?: null,
            'limit' => $this->limit ?: null,
            'page' => $this->page ?: null,
            'order' => $this->order ?: null,
        ];

        return http_build_query($params);
    }

    protected function handleResponse($response)
    {
        if ($response->failed()) {
            return new ErrorResponse($response);
        }

        return new SuccessResponse($this, $this->resource, $response);
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
     * @return ResourceInterface
     */
    public function find(string $id)
    {
        $this->resourceId = $id;

        return data_get($this->get()->data, 0, []);
    }

    /**
     * Limit how many records are returned at once
     *
     * @param  int|string  $limit
     *
     * @return $this
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
     * Alias for Ghost's include
     * Possible includes: authors, tags, count.posts
     *
     * @param  string|array  ...$includes
     *
     * @return $this
     */
    public function include(...$includes): BaseApi
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
    public function format(string $format): BaseApi
    {
        $this->formats = $format;

        return $this;
    }

    /**
     * @param  int  $page
     * @return $this
     */
    public function page(int $page): BaseApi
    {
        $this->page = strval($page);

        return $this;
    }

    /**
     * @param  string  $attr
     * @param  string  $order
     * @return $this
     */
    public function orderBy(string $attr, string $order = "DESC"): ContentApi
    {
        $this->order = $attr." ".strtolower($order);

        return $this;
    }
}
