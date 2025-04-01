<?php
use Slim\Factory\AppFactory;

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/controllers/AlunniController.php';

$app = AppFactory::create();

$app->get('/alunni', "AlunniController:index");
$app->get('/alunni/{id:\d+}', "AlunniController:show");//per ricercare alunni tramite ID (regular expression per controllare se il carattere è numerico)
$app->post('/alunni', "AlunniController:create");
$app->post('/alunni/{id:\d+}', "AlunniController:remove");
$app->put('/alunni/{id:\d+}', "AlunniController:edit");
$app->get('/alunni/search/{stringaDaCercare}', "AlunniController:searchParameter"); //search per catalogare la rotta e differenziarla dalle operazioni CRUD
$app->run();


//http://localhost:8080/alunni

//CREDENZIALI PHP MYADMIN (porta 81)
//username: root
//password: ciccio