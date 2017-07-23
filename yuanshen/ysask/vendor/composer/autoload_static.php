<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit54f1a7b5f273ec4d0c60ecebbfd3662e
{
    public static $prefixLengthsPsr4 = array (
        'h' => 
        array (
            'hightman\\xunsearch\\' => 19,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'hightman\\xunsearch\\' => 
        array (
            0 => __DIR__ . '/..' . '/hightman/xunsearch/wrapper/yii2-ext',
        ),
    );

    public static $classMap = array (
        'EXunSearch' => __DIR__ . '/..' . '/hightman/xunsearch/wrapper/yii-ext/EXunSearch.php',
        'XS' => __DIR__ . '/..' . '/hightman/xunsearch/lib/XS.class.php',
        'XSCommand' => __DIR__ . '/..' . '/hightman/xunsearch/lib/XSServer.class.php',
        'XSComponent' => __DIR__ . '/..' . '/hightman/xunsearch/lib/XS.class.php',
        'XSDocument' => __DIR__ . '/..' . '/hightman/xunsearch/lib/XSDocument.class.php',
        'XSErrorException' => __DIR__ . '/..' . '/hightman/xunsearch/lib/XS.class.php',
        'XSException' => __DIR__ . '/..' . '/hightman/xunsearch/lib/XS.class.php',
        'XSFieldMeta' => __DIR__ . '/..' . '/hightman/xunsearch/lib/XSFieldScheme.class.php',
        'XSFieldScheme' => __DIR__ . '/..' . '/hightman/xunsearch/lib/XSFieldScheme.class.php',
        'XSIndex' => __DIR__ . '/..' . '/hightman/xunsearch/lib/XSIndex.class.php',
        'XSSearch' => __DIR__ . '/..' . '/hightman/xunsearch/lib/XSSearch.class.php',
        'XSServer' => __DIR__ . '/..' . '/hightman/xunsearch/lib/XSServer.class.php',
        'XSTokenizer' => __DIR__ . '/..' . '/hightman/xunsearch/lib/XSTokenizer.class.php',
        'XSTokenizerFull' => __DIR__ . '/..' . '/hightman/xunsearch/lib/XSTokenizer.class.php',
        'XSTokenizerNone' => __DIR__ . '/..' . '/hightman/xunsearch/lib/XSTokenizer.class.php',
        'XSTokenizerScws' => __DIR__ . '/..' . '/hightman/xunsearch/lib/XSTokenizer.class.php',
        'XSTokenizerSplit' => __DIR__ . '/..' . '/hightman/xunsearch/lib/XSTokenizer.class.php',
        'XSTokenizerXlen' => __DIR__ . '/..' . '/hightman/xunsearch/lib/XSTokenizer.class.php',
        'XSTokenizerXstep' => __DIR__ . '/..' . '/hightman/xunsearch/lib/XSTokenizer.class.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit54f1a7b5f273ec4d0c60ecebbfd3662e::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit54f1a7b5f273ec4d0c60ecebbfd3662e::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit54f1a7b5f273ec4d0c60ecebbfd3662e::$classMap;

        }, null, ClassLoader::class);
    }
}
