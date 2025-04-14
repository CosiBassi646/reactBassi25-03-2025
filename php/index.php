<?php
use Slim\Factory\AppFactory;

//IMPORTANTI
require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/controllers/AlunniController.php';
require __DIR__ . '/controllers/CertificazioniController.php';

$app = AppFactory::create();

$app->get('/alunni', "AlunniController:index");
$app->get('/alunni/{id:\d+}', "AlunniController:show");//per ricercare alunni tramite ID (regular expression per controllare se il carattere è numerico)
$app->post('/alunni', "AlunniController:create");
$app->post('/alunni/{id:\d+}', "AlunniController:remove");
$app->put('/alunni/{id:\d+}', "AlunniController:edit");
$app->get('/alunni/search/{stringaDaCercare}', "AlunniController:searchParameter"); //search per catalogare la rotta e differenziarla dalle operazioni CRUD

//rotte per certificazioni
$app->get('/alunni/{id:\d+}/certificazioni', "CertificazioniController:index");
$app->get('/alunni/{alunno_id:\d+}/certificazioni/{certificazione_id:\d+}', "CertificazioniController:showCertificazione");
$app->post('/alunni/{alunno_id:\d+}/certificazioni', "CertificazioniController:createCertificazione");
$app->delete('/alunni/{alunno_id:\d+}/certificazioni/{certificazione_id:\d+}', "CertificazioniController:removeCertificazione");
$app->put('/alunni/{alunno_id:\d+}/certificazioni/{certificazione_id:\d+}', "CertificazioniController:editCertificazione");
$app->run();
//http://localhost:8080/alunni

//CREDENZIALI PHP MYADMIN (porta 81)
//username: root
//password: ciccio