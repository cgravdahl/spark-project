<?php

require __DIR__ . '/../vendor/autoload.php';

$fluentpdo = new FluentPDO(new PDO("mysql:dbname=spark_project","cody","password"));

$injector = new \Auryn\Injector;
$injector ->share($fluentpdo);

$app = Spark\Application::boot($injector);

$app->setMiddleware([
    'Relay\Middleware\ResponseSender',
    'Spark\Handler\ExceptionHandler',
    'Spark\Handler\RouteHandler',
    'Spark\Handler\ContentHandler',
    'Spark\Handler\ActionHandler',
]);

$app->addRoutes(function (Spark\Router $r) {
    $r->get('/hello[/{name}]', 'Spark\Project\Domain\Hello');
    $r->get('/user/{name}','Spark\Project\Domain\GetUser');
    $r->post('/hello[/{name}]', 'Spark\Project\Domain\Hello');
    $r->post('/user', 'Spark\Project\Domain\CreateUser');
});

$app->run();
