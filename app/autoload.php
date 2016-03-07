<?php
/**
 * Created by PhpStorm.
 * User: marquis
 * Date: 16/3/7
 * Time: 下午12:07
 */

use Doctrine\Common\Annotations\AnnotationRegistry;
use Composer\Autoload\ClassLoader;

/**
 * @var ClassLoader $loader
 */
$loader = require __DIR__.'/../vendor/autoload.php';

AnnotationRegistry::registerLoader(array($loader, 'loadClass'));

return $loader;
