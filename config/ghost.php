<?php

return [
    /**
     * The API version of your Ghost blog
     *
     * Read about Ghost API Versioning in their docs:
     * https://ghost.org/docs/faq/api-versioning/
     */
    'ghost_api_version' => env("GHOST_API_VERSION", 4),

    /**
     * Your admin domain can be different to your main domain.
     * All Ghost(Pro) blogs have a `.ghost.io` domain
     * as their admin domain and require https.
     */
    'admin_domain' => env('GHOST_ADMIN_DOMAIN', "https://{admin_domain}"),

    /**
     * The Content API URL and key can be obtained by creating a new
     * Custom Integration under the Integrations screen in Ghost Admin.
     */
    'content_key' => env('GHOST_CONTENT_API_KEY', ''),

    /**
     * The Content API URL and key can be obtained by creating a new
     * Custom Integration under the Integrations screen in Ghost Admin.
     */
    'admin_key' => env('GHOST_ADMIN_API_KEY', ''),

    /**
     * When debugging is enabled, Ghost API error messages will be returned,
     * otherwise the default error message takes place.
     */
    'debug' => [
        'enabled' => env('GHOST_DEBUG_ENABLED', true),
        'default_error_message' => 'Something went wrong. Please try again later.',
    ],

    /**
     * SEO properties that are automatically added to posts, pages and tags
     */
    'seo' => [
        'properties' => [
            'og_image',
            'og_title',
            'og_description',
            'twitter_image',
            'twitter_title',
            'twitter_description',
            'meta_title',
            'meta_description',
            'canonical_url',
        ],
        'models-with' => [
            \Igorsgm\Ghost\Models\Resources\Post::class,
            \Igorsgm\Ghost\Models\Resources\Page::class,
            \Igorsgm\Ghost\Models\Resources\Tag::class,
        ],
    ],

    /**
     * Experimental
     * Optionally, cache records when they are returned.
     */
    'cache' => [
        /**
         * Cache returned records
         * Set to false if you want to handle caching yourself
         */
        'cache_records' => false,

        /**
         * Prefix key used to save to cache
         * Ex. ghost_posts
         */
        'cache_prefix' => 'ghost_',

        /**
         * How long until cache expires
         * Accepts int in seconds, or DateTime instance
         */
        'ttl' => 60 * 60,
    ],
];
