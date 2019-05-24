<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;


if(file_exists('../vendor/autoload.php')){
    require '../vendor/autoload.php';
}

$app = new \Slim\App;

$app->get('/hello/{name}', function (Request $request, Response $response, array $args) {
    $name = $args['name'];
    $response->getBody()->write("Hello, $name");

    return $response;
});


new Api\Routes\Products($app);
new Api\Routes\Orders($app);
$app->add(function ($req, $res, $next) {
    $response = $next($req, $res);
    return $response            
            ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
            ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS');
});

$app->run();
