<?php

use Doctrine\Common\Annotations\AnnotationRegistry;

$vendor = getenv('SYMFONY_PATH');
$loader = require $vendor . '/autoload.php';

// intl
if (!function_exists('intl_get_error_code')) {
    require_once $vendor . '/symfony/symfony/src/Symfony/Component/Locale/Resources/stubs/functions.php';

    $loader->add('', $vendor . '/symfony/symfony/src/Symfony/Component/Locale/Resources/stubs');
}

$loader->add('', __DIR__ . '/../src');

AnnotationRegistry::registerLoader(array($loader, 'loadClass'));

return $loader;
