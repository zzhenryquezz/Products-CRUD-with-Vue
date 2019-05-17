<?php

// error_reporting(E_ALL);
// ini_set('display_errors', 1);

use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;


if(file_exists('../vendor/autoload.php')){
    require '../vendor/autoload.php';
}
$db = new Includes\Database();

$app = new \Slim\App;

$app->get('/hello/{name}', function (Request $request, Response $response, array $args) {
    $name = $args['name'];
    $response->getBody()->write("Hello, $name");

    return $response;
});

new Api\Routes\Products($app);

$app->run();
