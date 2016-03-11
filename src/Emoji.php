<?php

/**
 * An iOS Emoji Parser For Laravel 5
 *
 * @author euclid1990
 */
namespace euclid1990\PhpIosEmoji;

use Exception;
use Illuminate\Config\Repository;

class Emoji {

    /**
     * @var Repository
     */
    protected $config;

    /**
     * @var string
     */
    protected $assetPath;

    /**
     * @var string
     */
    protected $ecodeToImageFile;

    /**
     * @var array
     */
    protected $ecodeToImageList = [];

    /**
     * @var string
     */
    protected $ecodeToAliasFile;

    /**
     * @var array
     */
    protected $ecodeToAliasList = [];

    /**
     * @var string
     */
    protected $ignoredRegexp = '<object[^>]*>.*?<\/object>|<span[^>]*>.*?<\/span>|<(?:object|embed|svg|img|div|span|p|a)[^>]*>';

    /**
     * @var string
     */
    protected $ecodeRegexp = ':([-+\\w]+):';

    /**
     * Constructor
     *
     * @param Repository $config
     */
    function __construct(Repository $config)
    {
        $this->config = $config;
    }

    /**
     * Get camel case string
     *
     * @param  string  $word
     * @return string
     */
    public function camel($word)
    {
        return lcfirst(str_replace(' ', '', ucwords(strtr($word, '_-', '  '))));
    }

    /**
     * Generate an asset path for the application.
     *
     * @param  string  $path
     * @param  bool    $secure
     * @return string
     */
    public function asset($path, $secure = null)
    {
        if (function_exists('asset')) {
            return asset($path, $secure);
        }
        return $path;
    }

    /**
     * Init configuration
     *
     * @param  string  $config
     * @return void
     */
    protected function configure($config)
    {
        if ($this->config->has('emoji.' . $config)) {
            foreach($this->config->get('emoji.' . $config) as $key => $val) {
                $key = $this->camel($key);
                $this->{$key} = $val;
            }
        }
        if (is_null($this->ecodeToImageFile)) {
            $this->ecodeToImageFile = __DIR__ . '/../data/ecode_to_image.php';
        }
        if (is_null($this->ecodeToAliasFile)) {
            $this->ecodeToAliasFile = __DIR__ . '/../data/ecode_to_alias.php';
        }
        try {
            $this->ecodeToImageList = require $this->ecodeToImageFile;
            $this->ecodeToAliasList = require $this->ecodeToAliasFile;
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Parse string and determine if it contains an emoji.
     *
     * @param  string  $string
     * @param  string  $config
     * @return string
     */
    public function parse($string, $config = 'default')
    {
        $this->configure($config);
        return $this->ecodeToImage($string);
    }

    /**
     * Return markup image from emoji code input.
     *
     * @param  string  $string
     * @return string  String with appropriate html for rendering emoji.
     */
    public function ecodeToImage($string)
    {
        $string = preg_replace_callback('/'.$this->ignoredRegexp.'|('.$this->ecodeRegexp.')/Si', [$this, 'ecodeToImageCallback'], $string);
        return $string;
    }

     /**
      * Return image html of emoji
      * @param  array   $m  Results of preg_replace_callback().
      * @return string  Image HTML replacement result.
      */
    public function ecodeToImageCallback($m)
    {
        if ((!is_array($m)) || (!isset($m[1])) || (empty($m[1]))) {
            return $m[0];
        } else {
            $ecode = $m[1];
            if (!isset($this->ecodeToImageList[$ecode])) {
                return $m[0];
            }
            $filename = $this->ecodeToImageList[$ecode];
            $alt = $ecode;
            if (isset($this->ecodeToAliasList[$ecode])) {
                $alt = $this->ecodeToAliasList[$ecode];
            } elseif ($isset($m[2])) {
                $alt = $m[2];
            }
            return '<img class="ios-emoji" alt="'.$alt.'" src="' . $this->asset($this->assetPath . 'img/' . $filename) . '"/>';
        }
    }
}