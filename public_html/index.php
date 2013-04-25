<?php

use Quick\FrontController as FrontController;
use Quick\Http\Request as Request;
use Quick\Http\Response as Response;

// directories auto-configuration
$rootDir = dirname(__DIR__);
$vendorDir = $rootDir . '/vendor';

// setup autoloading
require $vendorDir . '/Quick/Autoloader.php';
$autoloader = new Quick\Autoloader($vendorDir);
$autoloader->register();

// load configuration & run app
$conf = include $rootDir . '/config.php';
$fc = new FrontController($rootDir, $conf);

// get data from request & output to browser
$request = new Request(Request::AUTO_INIT);
$response = new Response();
$fc->run($request, $response);