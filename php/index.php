<?php
use Slim\Factory\AppFactory;

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/controllers/AlunniController.php';

$app = AppFactory::create();

$app->get('/alunni', "AlunniController:index");
$app->get('/alunni/{id:\d+}', "AlunniController:show");
$app->post('/alunni', "AlunniController:create");
$app->post('/alunni/{id:\d+}', "AlunniController:remove");
$app->put('/alunni/{id:\d+}', "AlunniController:edit");
$app->run();
