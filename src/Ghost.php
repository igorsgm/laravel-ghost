<?php

namespace Igorsgm\Ghost;

use Igorsgm\Ghost\Models\Author;
use Igorsgm\Ghost\Models\Meta;
use Igorsgm\Ghost\Models\Page;
use Igorsgm\Ghost\Models\Post;
use Igorsgm\Ghost\Models\Settings;
use Igorsgm\Ghost\Models\Tag;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;

class Ghost
{
    /**
     * @var mixed
     */
    public $resourceModel;

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
     * @return Collection|array[]
     */
    public function all()
    {
        return $this->limit('all')->get();
    }

    /**
     * @return Collection|array[]
     */
    public function get()
    {
        $response = Http::get($this->make());

        if (in_array($response->status(), [404, 422])) {
            return [];
        }

        $resourceName = $this->resourceModel->getResourceName();
        $responseData = $response->json($resourceName);
        $meta = $response->json('meta');

        return $this->buildResponse($resourceName, $responseData, $meta);
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
        $endpoint = $this->resourceModel->getResourceName();
        if (!empty($this->resourceId)) {
            $endpoint .= "/{$this->resourceId}";
        } elseif (!empty($this->resourceSlug)) {
            $endpoint .= "/slug/{$this->resourceSlug}";
        }

        return $endpoint;
    }

    /**
     * @param  string  $resourceName
     * @param  array  $response
     * @param  array  $meta
     * @return array
     */
    protected function buildResponse($resourceName, $responseData, $meta = null): object
    {
        if ($resourceName == 'settings') {
            $data = $this->resourceModel::createFromArray($responseData);
        } else {
            $data = collect();
            foreach ($responseData as $resourceProperty) {
                $data->push($this->resourceModel::createFromArray($resourceProperty));
            }
        }

        return (object) [
            'data' => (empty($data) || ($data instanceof Collection && $data->isEmpty())) ? [] : $data,
            'meta' => Meta::createFromArray($meta),
        ];
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
        $this->resourceModel = $resource;

        return $this;
    }

    /**
     * @return $this
     */
    public function posts(): Ghost
    {
        $this->resourceModel = resolve(Post::class);

        return $this;
    }

    /**
     * @return $this
     */
    public function authors(): Ghost
    {
        $this->resourceModel = resolve(Author::class);

        return $this;
    }

    /**
     * @return $this
     */
    public function tags(): Ghost
    {
        $this->resourceModel = resolve(Tag::class);

        return $this;
    }

    /**
     * @return $this
     */
    public function pages(): Ghost
    {
        $this->resourceModel = resolve(Page::class);

        return $this;
    }

    /**
     * @return $this
     */
    public function settings(): Ghost
    {
        $this->resourceModel = resolve(Settings::class);

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

        return data_get($this->get(), 0, []);
    }

    /**
     * Return resource from slug
     *
     * @param  string  $slug
     *
     * @return array
     */
    public function fromSlug(string $slug)
    {
        $this->resourceSlug = $slug;

        return data_get($this->get(), 0, []);
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
