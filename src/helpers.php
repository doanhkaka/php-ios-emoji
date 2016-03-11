<?php

if (!function_exists('ios_emoji')) {
    /**
     * @param  string  $config
     * @return mixed
     */
    function ios_emoji($string, $config = 'default')
    {
        return app('ios_emoji')->parse($string, $config);
    }
}