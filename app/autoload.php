<?php

use Doctrine\Common\Annotations\AnnotationRegistry;
use Composer\Autoload\ClassLoader;

/**
 * @var ClassLoader $loader
 */
$loader = require __DIR__.'/../vendor/autoload.php';

////custom for Application
//$loader->add("Application", __DIR__);

AnnotationRegistry::registerLoader(array($loader, 'loadClass'));

return $loader;
