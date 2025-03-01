<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitb0bd399742e99e77ef67580e8f5076f4
{
    public static $prefixLengthsPsr4 = array (
        'P' => 
        array (
            'Plasticbrain\\FlashMessages\\' => 27,
            'PHPMailer\\PHPMailer\\' => 20,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Plasticbrain\\FlashMessages\\' => 
        array (
            0 => __DIR__ . '/..' . '/plasticbrain/php-flash-messages/src',
        ),
        'PHPMailer\\PHPMailer\\' => 
        array (
            0 => __DIR__ . '/..' . '/phpmailer/phpmailer/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitb0bd399742e99e77ef67580e8f5076f4::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitb0bd399742e99e77ef67580e8f5076f4::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
