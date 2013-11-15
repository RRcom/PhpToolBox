<?php
namespace RRcom\PhpToolBox;

class Config {

    const DEFAULT_CONFIG_DIR = '../../../config/';
    const DEFAULT_CONFIG_FILE = 'config.local.php';

    public $config;
    
    public function __construct($config = '') {
        $this->config = array();
        if($config === '') $config = $this->getConfigFromFile();
        if(is_array($config)) $this->mergeConfigArray($config);
        elseif(is_file($config)) $this->mergeConfigFile($config);
    }
    
    public function mergeConfigArray($configArray) {
        if(is_array($configArray)) $this->config = array_merge($this->config, $configArray);
        return $this->config;
    }
    
    public function mergeConfigFile($configFile) {
        if(is_file($configFile)) {
            $config = include $configFile;
            $this->mergeConfigArray($config);
        }
        return $config;
    }
    
    public function getConfig() {
        return $this->config;
    }
    
    static function getConfigFromFile($configFile = '') {
        if(is_file($configFile)) return (array) include $configFile;
        if(!is_file(__DIR__.'/'.self::DEFAULT_CONFIG_DIR.self::DEFAULT_CONFIG_FILE)) {
            $cfgFile = fopen(__DIR__.'/'.self::DEFAULT_CONFIG_DIR.self::DEFAULT_CONFIG_FILE, 'w');
            fwrite($cfgFile, file_get_contents(__DIR__.'/'.self::DEFAULT_CONFIG_DIR.'sample.config.php'));
            fclose($cfgFile);
        }
        return (array) include __DIR__.'/'.self::DEFAULT_CONFIG_DIR.self::DEFAULT_CONFIG_FILE;
    }
}

