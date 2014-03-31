<?php namespace PageBoost\HipChatV2\Laravel;

use Illuminate\Support\ServiceProvider;
use PageBoost\HipChatV2\HipChatFactory;

class HipchatServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    public function boot()
    {
        $this->package('pageboost/hipchat-php-v2');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('hipchat-v2', function ($app) {

            return HipChatFactory::instance();
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array('hipchat-v2');
    }
}
