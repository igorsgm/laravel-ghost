<?php

namespace Igorsgm\Ghost\Apis;

use Firebase\JWT\JWT;
use Igorsgm\Ghost\Models\Resources\Page;
use Igorsgm\Ghost\Models\Resources\Post;
use Igorsgm\Ghost\Models\Resources\Tag;
use Igorsgm\Ghost\Responses\ErrorResponse;
use Igorsgm\Ghost\Responses\SuccessResponse;
use Illuminate\Support\Facades\Http;

class AdminApi extends BaseApi
{
    /**
     * @var string
     */
    public string $resourceSlug = "";

    /**
     * @var string
     */
    private string $adminToken;

    /**
     * @param  array  $params  Here you can provide 'key', 'domain', 'version' to override the default ones.
     */
    public function __construct(array $params = [])
    {
        $this->key = data_get($params, 'key') ?? config('ghost.admin_key');
        $this->domain = data_get($params, 'domain') ?? config('ghost.admin_domain');
        $this->version = data_get($params, 'version') ?? config('ghost.ghost_api_version');
        $this->baseUrl = sprintf("%s/ghost/api/v%s/admin", rtrim($this->domain, '/'), $this->version);
        $this->adminToken = $this->adminToken($this->key);
    }

    /**
     * Generates JSON Web Token (JWT) from Ghost Admin API key
     *
     * @param $adminKey
     * @return string
     * @read https://ghost.org/docs/admin-api/#token-authentication
     */
    private function adminToken($adminKey)
    {
        //Step 1: Split the API key by the : into an id and a secret
        list($id, $secret) = explode(':', $adminKey);

        // Step 3: Decode the hexadecimal secret into the original binary byte array
        $decodedSecret = pack('H*', $secret);

        //Step 3: Pass these values to JWT library, ensuring that the header and payload are correct.
        $payload = [
            'exp' => strtotime('+10 minutes'), //expiration Unix timestamp
            'iat' => time(), //Issued at Time, Unix timestamp
            'aud' => "/v{$this->version}/admin/", //audience
        ];
        $token = JWT::encode($payload, $decodedSecret, 'HS256', $id);

        //debug. return original payload
        //$decoded = JWT::decode($token, $decodedSecret, ['HS256']);

        return $token;
    }

    /**
     * @return \Illuminate\Http\Client\PendingRequest
     */
    public function getHttpClient()
    {
        return Http::withHeaders([
            'Authorization' => 'Ghost '.$this->adminToken,
        ]);
    }

    /**
     * @return SuccessResponse|ErrorResponse
     */
    public function get()
    {
        $response = $this->getHttpClient()->get($this->makeApiUrl());
        return $this->handleResponse($response);
    }

    /**
     * @param  array  $data
     * @return SuccessResponse|ErrorResponse
     */
    public function create(array $data)
    {
        $response = $this->getHttpClient()->post($this->makeApiUrl(), [
            $this->resource->getResourceName() => [$data],
        ]);

        return $this->handleResponse($response);
    }

    /**
     * @param  string  $id
     * @param  array  $data
     * @return SuccessResponse|ErrorResponse
     */
    public function update(string $id, array $data)
    {
        $this->resourceId = $id;

        $response = $this->getHttpClient()->put($this->makeApiUrl(), [
            $this->resource->getResourceName() => [$data],
        ]);

        return $this->handleResponse($response);
    }

    /**
     * @param  string  $id
     * @return SuccessResponse|ErrorResponse
     */
    public function delete(string $id)
    {
        $this->resourceId = $id;

        $response = $this->getHttpClient()->delete($this->makeApiUrl());
        return $this->handleResponse($response);
    }

    /**
     * The post creation/update endpoint is also able to convert HTML into mobiledoc.
     * The conversion generates the best available mobiledoc representation,
     * meaning this operation is lossy and the HTML rendered by Ghost may be different from the source HTML.
     * For the best results ensure your HTML is well-formed, e.g. uses block and inline elements correctly.
     *
     * @param  string  $source
     *
     * @return $this
     */
    public function source(string $source): AdminApi
    {
        $this->source = $source;

        return $this;
    }

    /**
     * @return $this
     */
    public function posts(): AdminApi
    {
        return $this->setResource(Post::class);
    }

    /**
     * @return $this
     */
    public function pages(): AdminApi
    {
        return $this->setResource(Page::class);
    }

    /**
     * @return $this
     */
    public function tags(): AdminApi
    {
        return $this->setResource(Tag::class);
    }
}
