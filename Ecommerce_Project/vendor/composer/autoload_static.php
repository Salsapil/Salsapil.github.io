<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit18c1fd2b4d53a4df8c5f6a3a311c5b21
{
    public static $prefixLengthsPsr4 = array (
        'A' => 
        array (
            'App\\Classes\\' => 12,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'App\\Classes\\' => 
        array (
            0 => __DIR__ . '/../..' . '/classes',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit18c1fd2b4d53a4df8c5f6a3a311c5b21::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit18c1fd2b4d53a4df8c5f6a3a311c5b21::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit18c1fd2b4d53a4df8c5f6a3a311c5b21::$classMap;

        }, null, ClassLoader::class);
    }
}
