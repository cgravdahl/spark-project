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
    $r->get('/user/{name}','Spark\Project\Domain\GetUser');
    $r->get('/schedule/{id}','Spark\Project\Domain\GetSchedule');
    $r->post('/user', 'Spark\Project\Domain\CreateUser');
});

$app->run();
?>