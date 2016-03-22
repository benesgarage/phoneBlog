<?php
use ScientiaMobile\WurflCloud\Config;
use ScientiaMobile\WurflCloud\Cache\APC;
use ScientiaMobile\WurflCloud\Cache\Memcache;
use ScientiaMobile\WurflCloud\Cache\Memcached;
use ScientiaMobile\WurflCloud\Cache\File;
use ScientiaMobile\WurflCloud\Cache\Null;
use ScientiaMobile\WurflCloud\Cache\Cookie;
use ScientiaMobile\WurflCloud\Client;

class MyWurfl {

    private static $api_key = '794066:UYQaESJrucgC3V6vlsem8IfPLAq0R7yX';

    private static function init() {
        require_once __DIR__.'/src/autoload.php';

        $config = new Config();
        $config->api_key = self::$api_key;


        $cache = new Cookie();


        self::$instance = new Client($config, $cache);
        self::$instance->detectDevice();
    }

    public static function get($capability_name) {
        if (self::$instance === null) self::init();
        return self::$instance->getDeviceCapability($capability_name);
    }
    public static function getInstance() {
        return self::$instance;
    }

    private static $instance;
}