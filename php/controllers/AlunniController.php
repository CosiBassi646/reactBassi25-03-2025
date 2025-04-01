<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class AlunniController
{
  public function index(Request $request, Response $response, $args){
    $mysqli_connection = new MySQLi('my_mariadb', 'root', 'ciccio', 'scuola'); //credenziali di accessp a php myAdmin
    $result = $mysqli_connection->query("SELECT * FROM alunni");
    $results = $result->fetch_all(MYSQLI_ASSOC);

    $response->getBody()->write(json_encode($results));
    return $response->withHeader("Content-type", "application/json")->withStatus(200);
  }

  public function show(Request $request, Response $response, $args){ //metodo per ricercare un'alunno tramite id
    $mysqli_connection = new MySQLi('my_mariadb', 'root', 'ciccio', 'scuola'); //credenziali di accessp a php myAdmin
    //$response->getBody()->write($args["id"]);
    $result = $mysqli_connection->query("SELECT * FROM alunni WHERE alunni.id = $args[id] ");
    $results = $result->fetch_all(MYSQLI_ASSOC);
    
    if(empty($results)){
      $response->getBody()->write("NESSUNA CORRISPONDENZA"); //se non trova corrispondenze scrive un messaggio nel body
    }else{
      $response->getBody()->write(json_encode($results));
    }
    return $response;
  }

  public function create(Request $request, Response $response, $args){ //aggiungi uno studente al db
    $body= json_decode($request->getBody()->getContents(), true);
    $nome = $body["nome"];
    $cognome = $body["cognome"];
    $mysqli_connection = new MySQLi('my_mariadb', 'root', 'ciccio', 'scuola');
    $result = $mysqli_connection->query("INSERT INTO `alunni`(`nome`, `cognome`) VALUES ('$nome','$cognome')");

    return $response->withHeader("Content-Type", "application/json")->withStatus(200);
  }

  public function edit(Request $request, Response $response, $args){ //modifica i parametri di un'alunno dato l'id
    $body= json_decode($request->getBody()->getContents(), true);
    $response->getBody()->write($args["id"]);
    $nome = $body["nome"];
    $cognome = $body["cognome"];
    $mysqli_connection = new MySQLi('my_mariadb', 'root', 'ciccio', 'scuola');
    $result = $mysqli_connection->query("UPDATE `alunni` SET `nome`='$nome',`cognome`='$cognome' WHERE alunni.id = $args[id]");

    return $response->withHeader("Content-Type", "application/json")->withStatus(200);
  }

  public function remove(Request $request, Response $response, $args){ //elimina uno studente tramite id
    $mysqli_connection = new MySQLi('my_mariadb', 'root', 'ciccio', 'scuola'); //credenziali di accessp a php myAdmin
    $response->getBody()->write($args["id"]);
    $result = $mysqli_connection->query("DELETE FROM `alunni` WHERE alunni.id = $args[id] ");

    return $response->withHeader("Content-Type", "application/json")->withStatus(200);
  }

  public function searchParameter(Request $request, Response $response, $args){ //metodo per ricercare un'alunno per nome/cognome tramite dei caratteri passati in input
    $mysqli_connection = new MySQLi('my_mariadb', 'root', 'ciccio', 'scuola'); //connessione al DB
    //$response->getBody()->write($args["stringaDaCercare"]);
    $result = $mysqli_connection->query("Select * FROM alunni WHERE (alunni.nome LIKE '%$args[stringaDaCercare]%' || alunni.cognome LIKE '%$args[stringaDaCercare]%')");
    $results = $result->fetch_all(MYSQLI_ASSOC);
    $response->getBody()->write(json_encode($results));

    if(empty($results)){
      $response->getBody()->write("NESSUNA CORRISPONDENZA"); //se non trova corrispondenze scrive un messaggio nel body
    }else{
      $response->getBody()->write(json_encode($results));
    }
    return $response;
  }
  
/*
  public function sortBy(Request $request, Response $response, $args){ //ordina l'output del server in base ad una colonna della tabella scelta dall'utente
  $mysqli_connection = new MySQLi('my_mariadb', 'root', 'ciccio', 'scuola'); //connessione al DB
  $result = $mysqli_connection->query("describe alunni");//restituisce un'array che descrive il database e la struttura delle sue tabelle

  $found = false;
  
  $colums = result->fetch_all(MYSQLI_ASSOC);
  foreach($colums as $col){
    if($col['Field'] = $args['col']){
      $found = true;
      break;
    }
  }

  if(!$found){
    $response->getBody()->write(json_encode("COLONNA NON TROVATA"));
    return $response->withHeader("Content-Type", "application/json")->withStatus(404);
  }

  $result = $mysqli_connection->query("SELECT * FROM alunni ORDER BY $args['col'] ASC");//restituisce un'array che descrive il database e la struttura delle sue tabelle
  $results = $result->fetch_all(MYSQLI_ASSOC);
  $response->getBody()->write(json_encode($results));
  return $response->withHeader("Content-Type", "application/json")->withStatus(200);
  }

}
*/

//--PER IL CREATE
//curl -X POST http://localhost:8080/alunni -H "Content-Type: application/json" -d '{"nome": "guido", "cognome": "lauto"}'

//--PER IL DELETE
//curl -X POST http://localhost:8080/alunni/5

//--PER L'UPDATE
//curl -X PUT http://localhost:8080/alunni/3 -H "Content-Type: application/json" -d '{"nome": "GUIDO", "cognome": "LAUTO"}'