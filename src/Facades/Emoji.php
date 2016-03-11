<?php

namespace euclid1990\PhpIosEmoji\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @package \euclid1990\PhpIosEmoji
 */
class Emoji extends Facade {

    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
    	return 'ios_emoji';
    }
}