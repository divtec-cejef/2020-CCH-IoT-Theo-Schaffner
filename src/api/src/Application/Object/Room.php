<?php


namespace App\Application\Object;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;


class Room
{
    /*
     * Fonction qui retourne toutes les salles
     */
    public function getAllRoom (Request $request, Response $response, $args) {

        $db = new Database();
        $connection  = $db->getConnection();

        $query = "SELECT Room.RoomNumber as rNumb, Room.RoomName as rName FROM Room";

        $req = $connection->prepare($query);

        $req->execute();

        $data = [];

        while ($row = $req->fetch(\PDO::FETCH_ASSOC)) {
            $data[] = array(
                "Name" => $row['rNumb'],
                "Room" => $row['rName']
            );
        }
        $payload = json_encode($data);

        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json');
    }

    /*
     * Fonction qui retourne toutes les informations d'une salle à l'aide de son Id
     */
    public function getRoomById (Request $request, Response $response, $args) {
        $response->getBody()->write('La salle '. $args['id']. ' se nomme : B1-0'. $args['id']);
        return $response;
    }
    
    /*
     * Fonction qui retourne toutes les mesures d'une salle à l'aide de son Id
     */
    public function getRoomMeasuresById (Request $request, Response $response, $args) {
        $response->getBody()->write('La salle '. $args['id']. ' informe : 130e');
        return $response;
    }
}