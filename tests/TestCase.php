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
//        Factory::guessFactoryNamesUsing(function (string $modelName) {
//            'Igorsgm\\Ghost\\Database\\Factories\\'.class_basename($modelName).'Factory';
//        });

//        Http::fake([
//            '*authors*' => Http::response(file_get_contents(__DIR__.'/Fixtures/authors.json'), 200),
//            '*posts/slug/nonsense*' => Http::response([], 404),
//            '*posts*' => Http::response(file_get_contents(__DIR__.'/Fixtures/posts.json'), 200),
//            '*tags*' => Http::response(file_get_contents(__DIR__.'/Fixtures/tags.json'), 200),
//            '*pages*' => Http::response(file_get_contents(__DIR__.'/Fixtures/pages.json'), 200),
//            '*settings*' => Http::response(file_get_contents(__DIR__.'/Fixtures/settings.json'), 200),
//        ]);
    }

    /**
     * Define environment setup.
     *
     * @param  \Illuminate\Foundation\Application  $app
     *
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
            'cache' => [
                'cache_records' => false,
                'cache_prefix' => 'ghost_',
                'ttl' => 3600,
            ],
        ]);

        $this->config = $app['config'];
    }

    /**
     * Get package providers.
     *
     * @param  \Illuminate\Foundation\Application  $app
     *
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
     *
     * @return array
     */
    protected function getPackageAliases($app)
    {
        return [
            'Ghost' => Ghost::class,
        ];
    }
}
