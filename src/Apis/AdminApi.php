<?php

namespace Igorsgm\Ghost\Apis;

use Firebase\JWT\JWT;
use Igorsgm\Ghost\Models\Resources\Image;
use Igorsgm\Ghost\Models\Resources\Member;
use Igorsgm\Ghost\Models\Resources\Offer;
use Igorsgm\Ghost\Models\Resources\Page;
use Igorsgm\Ghost\Models\Resources\Post;
use Igorsgm\Ghost\Models\Resources\Site;
use Igorsgm\Ghost\Models\Resources\Tag;
use Igorsgm\Ghost\Models\Resources\Theme;
use Igorsgm\Ghost\Models\Resources\Tier;
use Igorsgm\Ghost\Models\Resources\User;
use Igorsgm\Ghost\Models\Resources\Webhook;
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
     * @param  string  $filePath  The path to the file you want to upload
     * @param  string  $ref  (optional) A reference or identifier for the image, e.g. the original filename and path.
     *                       Will be returned as-is in the API response, making it useful for finding & replacing
     *                       local image paths after uploads.
     *
     * @return ErrorResponse|SuccessResponse
     */
    public function upload($filePath, $ref = null)
    {
        $response = $this->getHttpClient()
            ->attach('file', file_get_contents($filePath), basename($filePath))
            ->post($this->makeApiUrl('/upload'), array_filter(compact('ref')));

        return $this->handleResponse($response);
    }

    /**
     * Activate a theme
     *
     * @param  string  $themeName
     * @return ErrorResponse|SuccessResponse
     */
    public function activate(string $themeName)
    {
        $this->resourceId = $themeName;
        $response = $this->getHttpClient()->put($this->makeApiUrl('/activate'));

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
     * @return AdminApi
     */
    public function source(string $source): AdminApi
    {
        $this->source = $source;

        return $this;
    }

    /**
     * Posts are the primary resource in a Ghost site, providing means for publishing, managing and displaying content.
     * At the heart of every post is a mobiledoc field, containing a standardised JSON-based representation of your
     * content, which can be rendered in multiple formats.
     * Methods: Browse, Read, Edit, Add, Delete
     *
     * @see https://ghost.org/docs/admin-api/#posts
     * @return AdminApi
     */
    public function posts(): AdminApi
    {
        return $this->setResource(Post::class);
    }

    /**
     * Pages are static resources that are not included in channels or collections on the Ghost front-end.
     * They are identical to posts in terms of request and response structure when working with the APIs.
     * Methods: Browse, Read, Edit, Add, Delete
     *
     * @see https://ghost.org/docs/admin-api/#pages
     * @return AdminApi
     */
    public function pages(): AdminApi
    {
        return $this->setResource(Page::class);
    }

    /**
     * Methods: Browse, Read, Edit, Add, Delete
     * @return AdminApi
     */
    public function tags(): AdminApi
    {
        return $this->setResource(Tag::class);
    }

    /**
     * Tiers allow publishers to create multiple options for an audience to become paid subscribers.
     * Each tier can have its own price points, benefits, and content access levels.
     * Ghost connects tiers directly to the publication’s Stripe account.
     * Methods: Browse, Read, Edit, Add
     *
     * @see https://ghost.org/docs/admin-api/#tiers
     * @return AdminApi
     */
    public function tiers(): AdminApi
    {
        return $this->setResource(Tier::class);
    }

    /**
     * Use offers to create a discount or special price for members signing up on a tier.
     * Methods: Browse, Read, Edit, Add
     *
     * @see https://ghost.org/docs/admin-api/#offers
     * @return AdminApi
     */
    public function offers(): AdminApi
    {
        return $this->setResource(Offer::class);
    }

    /**
     * The members resource provides an endpoint for fetching, creating, and updating member data.
     * Methods: Browse, Read, Edit, Add
     *
     * @see https://ghost.org/docs/admin-api/#members
     * @return AdminApi
     */
    public function members(): AdminApi
    {
        return $this->setResource(Member::class);
    }

    /**
     * Methods: Browse, Read
     *
     * @see https://ghost.org/docs/admin-api/#users
     * @return AdminApi
     */
    public function users(): AdminApi
    {
        return $this->setResource(User::class);
    }

    /**
     * Sending images to Ghost via the API allows you to upload images one at a time, and store them with a storage
     * adapter. The default adapter stores files locally in /content/images/ without making any modifications,
     * except for sanitising the filename.
     *
     * Methods: Upload
     *
     * @see https://ghost.org/docs/admin-api/#images
     * @return AdminApi
     */
    public function images(): AdminApi
    {
        return $this->setResource(Image::class);
    }

    /**
     * Themes can be uploaded from a local ZIP archive and activated.
     *
     * Methods: Upload, Activate
     *
     * @see https://ghost.org/docs/admin-api/#themes
     * @return AdminApi
     */
    public function themes(): AdminApi
    {
        return $this->setResource(Theme::class);
    }

    /**
     * Methods: Read
     *
     * @see https://ghost.org/docs/admin-api/#site
     * @return AdminApi
     */
    public function site(): AdminApi
    {
        return $this->setResource(Site::class);
    }

    /**
     * Webhooks allow you to build or set up custom integrations, which subscribe to certain events in Ghost.
     * When one of such events is triggered, Ghost sends a HTTP POST payload to the webhook’s configured URL.
     * For instance, when a new post is published Ghost can send a notification to configured endpoint to trigger
     * a search index re-build, slack notification, or whole site deploy.
     *
     * Methods: Edit, Add, Delete
     *
     * @see https://ghost.org/docs/admin-api/#webhooks
     * @read https://ghost.org/integrations/custom-integrations/#api-webhook-integrations
     * @read https://ghost.org/docs/webhooks/
     * @return AdminApi
     */
    public function webhooks(): AdminApi
    {
        return $this->setResource(Webhook::class);
    }
}
