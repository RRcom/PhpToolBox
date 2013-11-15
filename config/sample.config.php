<?php
return array(
    'facebook' => array(
        'appId' => '',
        'appSecret' => '',
    ),
    'connect' => array(
        'apiUrl' => '',
        'sslCheckCertificate' => FALSE,
        'authDomainLoginUrl' => '',
        'authDomainSecureLoginUrl' => '',
        'authDomainLogoutUrl' => '',
        'authDomainSecureLogoutUrl' => '',
        'authDomainFbLoginUrl' => '',
        'authDomainSecureFbLoginUrl' => '',
        'imageServer' => '',
        'requestExpire' => 180,
        'apiKey' => '',
    ),
    'session' => array(
        'cookieDomain' => '',
        'cookieName' => '',
        'cookieExpire' => 0,
        'encryptCookie' => FALSE,
        'encryptKey' => '',
        'encryptSalt' => '',
    ),
    'doctrine' => array(
        'connection' => array(
            'driver'   => 'pdo_mysql',
            'host'     => 'localhost',
            'dbname'   => '',
            'user'     => '',
            'password' => '',
        ),
        'isDevmode' => FALSE,
    ),
);