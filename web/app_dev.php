<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Debug\Debug;

require dirname(__DIR__).'/app/config/bootstrap.php';

umask(0000);

Debug::enable();

//// This check prevents access to debug front controllers that are deployed by accident to production servers.
//// Feel free to remove this, extend it, or make something more sophisticated.
//if (isset($_SERVER['HTTP_CLIENT_IP'])
//    || isset($_SERVER['HTTP_X_FORWARDED_FOR'])
//    || !(in_array(@$_SERVER['REMOTE_ADDR'], array('127.0.0.1', 'fe80::1', '::1', '192.168.1.1')) || php_sapi_name() === 'cli-server')
//) {
//    header('HTTP/1.0 403 Forbidden');
//    exit('You are not allowed to access this file. Check '.basename(__FILE__).' for more information.');
//}

$kernel = new AppKernel('dev', true);
$request = Request::createFromGlobals();
$response = $kernel->handle($request);
$response->send();
$kernel->terminate($request, $response);
