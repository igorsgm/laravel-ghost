<?php

namespace Igorsgm\Ghost\Tests;

use Igorsgm\Ghost\Ghost;
use Igorsgm\Ghost\GhostServiceProvider;

class TestCase extends \Orchestra\Testbench\TestCase
{
    /**
     * @var \Illuminate\Config\Repository
     */
    public $config;

    /**
     * @var \Igorsgm\Ghost\Apis\ContentApi
     */
    public $ghostContentApi;

    protected function setUp(): void
    {
        parent::setUp();
    }

    /**
     * Define environment setup.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return void
     */
    public function defineEnvironment($app)
    {
        $app['config']->set('database.default', 'sqlite');
        $app['config']->set('database.connections.sqlite', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);

        $app['config']->set('ghost', [
            'ghost_api_version' => 4,
            'admin_domain' => 'https://demo.ghost.io',
            'admin_key' => '1234:56789',
            'content_key' => '22444f78447824223cefc48062',
            'debug' => [
                'enabled' => true,
                'default_error_message' => 'Something went wrong. Please try again later.',
            ],
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
            'cache' => [
                'cache_records' => false,
                'cache_prefix' => 'ghost_',
                'ttl' => 3600,
            ],
        ]);

        $this->config = $app['config'];
    }

    /**
     * Retrieves the content of a Fixture json file, to mock Ghost Admin API responses.
     *
     * @param  string  $fileName
     * @return false|string
     */
    public function getFixtureJson($fileName)
    {
        return file_get_contents(__DIR__.'/Fixtures/'.$fileName);
    }

    /**
     * Get package providers.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            GhostServiceProvider::class,
        ];
    }

    /**
     * Override application aliases.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return array
     */
    protected function getPackageAliases($app)
    {
        return [
            'Ghost' => Ghost::class,
        ];
    }
}
