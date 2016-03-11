<?php

namespace euclid1990\PhpIosEmoji\Providers;

use euclid1990\PhpIosEmoji\Emoji;
use Illuminate\Support\ServiceProvider;

/**
 * @package \euclid1990\PhpIosEmoji
 */
class EmojiServiceProvider extends ServiceProvider {

    /**
     * Boot the service provider.
     *
     * @return null
     */
    public function boot()
    {
        // Publish configuration files
        $this->publishes([
            __DIR__ . '/../../config/emoji.php' => config_path('emoji.php')
        ], 'config');

        // Publish asset files
        $this->publishes([
            __DIR__ . '/../../assets' => public_path('ios-emoji'),
        ], 'public');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        // Merge configs
        $this->mergeConfigFrom(
            __DIR__.'/../../config/emoji.php', 'emoji'
        );
        // Bind captcha
        $this->app->bind('ios_emoji', function($app)
        {
            return new Emoji(
                $app['Illuminate\Config\Repository']
            );
        });
    }
}
