<?php
namespace RRcom\PhpToolBox;

use RRcom\PhpToolBox\Config;
use RRcom\PhpToolBox\Cryption;

class Session {

    public $config;
    public $session;

    /**
     * @param array $config Configuration for this session. You can also call Session::getDefaultConfig() to check what are config made off.
     */
    public function __construct(Array $config = NULL) {
        $this->session = array();
        $this->config = $this->getDefaultConfig();
        if($config === NULL) {
            $globalConfig = Config::getConfigFromFile();
            array_merge($this->config, $globalConfig['session']);
        }
        else array_merge($this->config, $config);
        $this->initSession();
    }

    /**
     * Add or set a session data
     * @param string|array $key keyname of data to be stored in a session or array of key value pair data
     * @param mixed $value the value of a key if key is string or null if key is array
     */

    public function setData($key, $value = '') {
        if(is_array($key)) {
            $this->session = array_merge($this->session, $key);
        }
        else $this->session[$key] = $value;
    }

    /**
     * Get data from session
     * @param string $key the name or key of value to fetch
     * @return mixed
     */

    public function getData($key) {
        if(!empty($this->session[$key])) return $this->session[$key];
        return '';
    }

    /**
     * Update cookie string from session array. Must call this after all setData() are done
     */

    public function flashData() {
        $value = serialize($this->session);
        $expire = intval($this->config['cookieExpire']) ? $this->config['cookieExpire'] + time() : 0;
        if((bool)$this->config['encryptCookie']) {
            $value = Cryption::encrypt($value, $this->config['encryptKey'], $this->config['encryptSalt']);
        }
        setcookie(
            $this->config['cookieName'],
            $value,
            $expire,
            '/',
            $this->config['cookieDomain']
        );
    }

    /**
     * Update session array from cookie string
     */

    public function initSession() {
        $cookie = '';
        if(!empty($_COOKIE[$this->config['cookieName']])) {
            $cookie = $_COOKIE[$this->config['cookieName']];
            if((bool)$this->config['encryptCookie']) {
                $cookie = Cryption::decrypt($cookie, $this->config['encryptKey'], $this->config['encryptSalt']);
            }
            $cookie = unserialize($cookie);
            if(!is_array($cookie)) $cookie = array();
            $this->session = array_merge($this->session, $cookie);
        }
    }

    static public function getDefaultConfig() {
        return array(
            'cookieDomain' => 'sample.domain', // the domain where the cookie will be available
            'cookieName' => 'sampleName', // name to be use as cookie key name in browser
            'cookieExpire' => 0, // time in sec to expire or if 0 on browser closed
            'encryptCookie' => TRUE, // Prevent cookie data to be read by hacker
            'encryptKey' => '', // The password/key for your encryption
            'encryptSalt' => '',
        );
    }

}