<?php

if (!function_exists('ios_emoji')) {
    /**
     * @param  string  $string
     * @param  string  $config
     * @return mixed
     */
    function ios_emoji($string, $config = 'default')
    {
        return app('ios_emoji')->parse($string, $config);
    }
}

if (!function_exists('ios_emoji_css')) {
    /**
     * @param  string  $config
     * @return mixed
     */
    function ios_emoji_css($config = 'default')
    {
        return app('ios_emoji')->css($config);
    }
}