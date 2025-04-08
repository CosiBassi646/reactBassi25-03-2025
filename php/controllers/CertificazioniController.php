<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class CertificazioniController
{
  //rotte per certificazioni
  public function index(Request $request, Response $response, $args){ 
    $mysqli_connection = new MySQLi('my_mariadb', 'root', 'ciccio', 'scuola'); 
    //$response->getBody()->write($args["id"]);
    $result = $mysqli_connection->query("SELECT * from certificazioni WHERE certificazioni.alunno_id = $args[id]");
    $results = $result->fetch_all(MYSQLI_ASSOC);
    
    if(empty($results)){
      $response->getBody()->write("NESSUNA CORRISPONDENZA");
    }else{
      $response->getBody()->write(json_encode($results));
    }
    return $response;
  }

  public function showCertificazione(Request $request, Response $response, $args){ 
    $mysqli_connection = new MySQLi('my_mariadb', 'root', 'ciccio', 'scuola'); 
    //$response->getBody()->write($args["id"]);
    $result = $mysqli_connection->query("SELECT * from certificazioni WHERE certificazioni.alunno_id = $args[id] and certificazioni.id = $args[id]");
    $results = $result->fetch_all(MYSQLI_ASSOC);
    
    if(empty($results)){
      $response->getBody()->write("NESSUNA CORRISPONDENZA");
    }else{
      $response->getBody()->write(json_encode($results));
    }
    return $response;
  }

  
}

