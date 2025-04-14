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

  public function showCertificazione(Request $request, Response $response, $args) {
    $mysqli_connection = new MySQLi('my_mariadb', 'root', 'ciccio', 'scuola');

    $alunno_id = (int) $args['alunno_id']; // esempio: 5
    $certificazione_id = (int) $args['certificazione_id']; // esempio: 2

    $query = "SELECT * FROM certificazioni WHERE alunno_id = $alunno_id AND id = $certificazione_id";
    $result = $mysqli_connection->query($query);

    if ($result && $result->num_rows > 0) {
        $results = $result->fetch_all(MYSQLI_ASSOC);
        $response->getBody()->write(json_encode($results))->withStatus(200);
    } else {
        $response->getBody()->write("NESSUNA CORRISPONDENZA")->withStatus(404);
    }

    return $response;
  }

  public function createCertificazione(Request $request, Response $response, $args) {
    $body = json_decode($request->getBody()->getContents(), true);

    $alunno_id = (int) $args["alunno_id"]; // presi dall'URL
    $titolo = $body["titolo"];
    $votazione = $body["votazione"];
    $ente = $body["ente"];

    $mysqli_connection = new MySQLi('my_mariadb', 'root', 'ciccio', 'scuola');
    $mysqli_connection->query("INSERT INTO `certificazioni` (`alunno_id`, `titolo`, `votazione`, `ente`) VALUES ('$alunno_id', '$titolo', '$votazione', '$ente')");

    return $response->withHeader("Content-Type", "application/json")->withStatus(201);
  }

  public function removeCertificazione(Request $request, Response $response, $args){ 
    $mysqli_connection = new MySQLi('my_mariadb', 'root', 'ciccio', 'scuola'); //credenziali di accessp a php myAdmin
    
    $alunno_id = (int) $args['alunno_id']; 
    $certificazione_id = (int) $args['certificazione_id']; 
    $result = $mysqli_connection->query("DELETE FROM `certificazioni` WHERE certificazioni.alunno_id = '$alunno_id' AND certificazioni.id = '$certificazione_id'");

    return $response->withHeader("Content-Type", "application/json")->withStatus(200);
  }

  public function editCertificazione(Request $request, Response $response, $args){ 
    $body = json_decode($request->getBody()->getContents(), true);
    $mysqli_connection = new MySQLi('my_mariadb', 'root', 'ciccio', 'scuola');

    $alunno_id = (int) $args["alunno_id"];
    $certificazione_id = (int) $args["certificazione_id"];
    $titolo = $body["titolo"];
    $votazione = $body["votazione"];

    $query = "UPDATE `certificazioni` 
              SET `titolo` = '$titolo', `votazione` = '$votazione' 
              WHERE `id` = $certificazione_id AND `alunno_id` = $alunno_id";

    $result = $mysqli_connection->query($query);

    if ($result) {
        $response->getBody()->write(json_encode(["esito" => "Certificazione aggiornata"]));
    } else {
        $response->getBody()->write(json_encode(["errore" => $mysqli_connection->error]));
        return $response->withStatus(500);
    }

    return $response->withHeader("Content-Type", "application/json")->withStatus(200);
}

  
}

//PER AGGIUNGERE UNA CERTIFICAZIONE AL DB
/*
curl -X POST http://localhost:8080/alunni/1/certificazioni   -H "Content-Type: application/json"   -d '{
  "titolo": "ECDL Base",
  "votazione": "85",
  "ente": "AICA"
}'
*/


//PER AGGIORNARE UNA CERTIFICAZIONE
/*
curl -X PUT http://localhost:8080/alunni/1/certificazioni/5 \
  -H "Content-Type: application/json" \
  -d '{
    "titolo": "Cambridge B2",
    "votazione": "89"
  }'
  */

  //PER CANCELLARE UNA CERTIFICAZIONE
  /*
  curl -X DELETE http://localhost:8080/alunni/3/certificazioni/7
  */
?>