<?php

// load the symfony UniversalClassLoader
require '/home/colin/development/frameworks/php/symfony/2.0/src/Symfony/Component/ClassLoader/UniversalClassLoader.php';

use Symfony\Component\ClassLoader\UniversalClassLoader;

$loader = new UniversalClassLoader();
$loader->registerNamespaces(array(
  'YATA' => __DIR__ . '/../lib',
));
$loader->register();
