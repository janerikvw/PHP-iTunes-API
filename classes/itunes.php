<?php

/**
 * iTunes class.
 *
 *
 * @author Jan Erik van Woerden <info@janerik.eu>
 *
 * @link https://github.com/ijanerik/PHP-iTunes-API
 *
 * @license MIT License
 *
 * @see http://www.apple.com/itunes/affiliates/resources/documentation/itunes-store-web-service-search-api.htm For more information about the configuration
 */
class itunes
{
    const API_LOOKUP = 'http://itunes.apple.com/lookup?';
    const API_SEARCH = 'http://itunes.apple.com/search?';

    /**
     * The lookup config.
     * 
     * (default value: array())
     * 
     * @var array
     * @static
     */
    protected static $_lookup_config = [];

    /**
     * The search config.
     * 
     * (default value: array())
     * 
     * @var array
     * @static
     */
    protected static $_search_config = [];

    /**
     * Set a new config.
     *
     * <code>
     * iTunes::config('index', 'value');
     * iTunes::config(array('index' => 'value'));
     * </code>
     * 
     * @static
     *
     * @param array|string $index (default: array())
     * @param string       $value (default: null)
     * @param string       $type  (default: 'search')
     *
     * @return void
     */
    public static function config($index = [], $value = null, $type = 'search')
    {
        if (!is_array($index)) {
            $index = [$index => $value];
        } elseif (is_array($index) && $value !== null) {
            $type = $value;
        }

        if ($type == 'lookup') {
            self::$_lookup_config = array_merge(self::$_lookup_config, $index);
        } else {
            self::$_search_config = array_merge(self::$_search_config, $index);
        }
    }

    /**
     * Search inside iTunes.
     * 
     * @static
     *
     * @param mixed $term
     * @param mixed $by     (default: null)
     * @param array $config (default: array())
     *
     * @return array
     */
    public static function search($term, $by = null, array $config = [])
    {
        if (is_array($by)) {
            $config = $by;
        } elseif ($by !== null) {
            $config['attribute'] = $by;
        }

        $config['term'] = $term;
        $content = self::_get_content($config, 'search');

        return $content;
    }

    /**
     * Look for artists or other objects inside iTunes.
     * 
     * @static
     *
     * @param string       $term
     * @param string|array $by     (default: 'id')
     * @param array        $config (default: array())
     *
     * @return array
     */
    public static function lookup($term, $by = 'id', array $config = [])
    {
        $config[$by] = $term;
        $content = self::_get_content($config, 'lookup');

        return $content;
    }

    /**
     * Get the content from the iTunes servers.
     * 
     * @static
     *
     * @param array  $config
     * @param string $type   (default: 'search')
     *
     * @return array
     */
    protected static function _get_content($config, $type = 'search')
    {
        if ($type == 'lookup') {
            $url = self::API_LOOKUP;
        } else {
            $url = self::API_SEARCH;
        }

        $url .= http_build_query($config);

        $content = file_get_contents($url);
        $array = json_decode($content);

        return $array;
    }
}
