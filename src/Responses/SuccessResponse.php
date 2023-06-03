<?php

namespace Igorsgm\Ghost\Responses;

use Igorsgm\Ghost\Apis\BaseApi;
use Igorsgm\Ghost\Models\Meta;
use Igorsgm\Ghost\Models\Resources\BaseResource;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Collection;

class SuccessResponse
{
    /**
     * @var BaseApi
     */
    private $api;

    /**
     * @var BaseResource
     */
    private $resource;

    /**
     * @var Response|mixed
     */
    private $response;

    /**
     * @var bool
     */
    public $success = true;

    /**
     * @var Collection|array
     */
    public $data = [];

    /**
     * @var Meta|array
     */
    public $meta = [];

    /**
     * @param  Response|mixed  $response
     */
    public function __construct(BaseApi $api, BaseResource $resource, $response)
    {
        $this->api = $api;
        $this->resource = $resource;
        $this->response = $response;

        $this->handle();
    }

    /**
     * @return void
     */
    private function handle()
    {
        $resourceName = $this->resource->getResourceName();
        $decodedResponse = $this->response->json();

        $responseData = data_get($decodedResponse, $resourceName);
        $meta = data_get($decodedResponse, 'meta');

        if (in_array($resourceName, ['settings', 'site'])) {
            $data = new $this->resource($responseData);
        } else {
            $data = collect();
            $responseData = ! empty($responseData) ? $responseData : [];
            foreach ($responseData as $resourceItemData) {
                $data->push(new $this->resource($resourceItemData));
            }
        }

        $this->data = $data;

        if (! empty($meta)) {
            $this->meta = new Meta($meta);
        }
    }

    /**
     * Fetches the Previous page response
     *
     * @return array|array[]|SuccessResponse
     */
    public function getPreviousPage()
    {
        $previusPage = $this->meta->prev();

        return $this->api->page($previusPage)->get();
    }

    /**
     * Fetches the Next page response
     *
     * @return array|array[]|SuccessResponse
     */
    public function getNextPage()
    {
        $nextPage = $this->meta->next();

        return $this->api->page($nextPage)->get();
    }
}
