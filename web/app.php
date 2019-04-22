<?php

use Symfony\Component\HttpFoundation\Request;

require dirname(__DIR__).'/app/config/bootstrap.php';

include_once __DIR__.'/../var/bootstrap.php.cache';


$kernel = new AppKernel('prod', false);
//$kernel = new AppCache($kernel);

// When using the HttpCache, you need to call the method in your front controller instead of relying on the configuration parameter
//Request::enableHttpMethodParameterOverride();
$request = Request::createFromGlobals();
$response = $kernel->handle($request);
$response->send();
$kernel->terminate($request, $response);
