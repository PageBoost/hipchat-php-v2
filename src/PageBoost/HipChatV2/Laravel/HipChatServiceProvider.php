<?php namespace PageBoost\HipChatV2\Laravel;

use Illuminate\Support\ServiceProvider;
use PageBoost\HipChatV2\HipChatFactory;
use PageBoost\HipChatV2\laravel\HipChatLaravel;
use PageBoost\HipChatV2\Resources\Emoticons;
use PageBoost\HipChatV2\Resources\Sessions;
use PageBoost\HipChatV2\Resources\Rooms;
use PageBoost\HipChatV2\Resources\Users;

class HipChatServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    public function boot()
    {
        $this->package('page-boost/hipchat-php-v2');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $app = $this->app;
        $app->singleton('hipchat-v2.httpClient', function ($app) {

            $config = $app['config']->get('hipchat-php-v2::config');

            // Check for Base Url (self-hosted HipChat Server)
            if (!empty($config['baseUrl'])) {
                HipChatFactory::$baseUrl = $config['baseUrl'];
            }

            $httpClient = HipChatFactory::createHttpClient();

            // Check for default OAuth Token
            if (!empty($config['oauthToken'])) {
                $httpClient->setAccessToken($config['oauthToken']);
            }

            return $httpClient;
        });

        $app->singleton('hipchat-v2.emoticons', function ($app) {

            return new Emoticons(null, $app['hipchat-v2.httpClient']);
        });

        $app->singleton('hipchat-v2.sessions', function ($app) {

            return new Sessions(null, $app['hipchat-v2.httpClient']);
        });

        $app->singleton('hipchat-v2.rooms', function ($app) {

            return new Rooms(null, $app['hipchat-v2.httpClient']);
        });

        $app->singleton('hipchat-v2.users', function ($app) {

            return new Users(null, $app['hipchat-v2.httpClient']);
        });

        $app->singleton('hipchat-v2', function ($app) {

            $config = $app['config']->get('hipchat-php-v2::config');
            $hipchat = new HipChatLaravel($app['hipchat-v2.httpClient'], $app['hipchat-v2.emoticons'], $app['hipchat-v2.sessions'], $app['hipchat-v2.rooms'], $app['hipchat-v2.users']);

            // Check for Default OAuth ID and Secret
            if (!empty($config['oauthId']) and !empty($config['oauthSecret'])) {
                $hipchat->setDefaultOauthId($config['oauthId']);
                $hipchat->setDefaultOauthSecret($config['oauthSecret']);
            }

            return $hipchat;
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array('hipchat-v2', 'hipchat-v2.httpClient', 'hipchat-v2.emoticons', 'hipchat-v2.sessions', 'hipchat-v2.rooms', 'hipchat-v2.users');
    }
}
