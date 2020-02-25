<?php


namespace App\Application\Object;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;


class Device
{
    /*
     * Fonction qui retourne tous les device de la base de donnée
     */
    public function getAllDevice (Request $request, Response $response) {

        $db = new Database();
        $connection  = $db->getConnection();

        $query = "SELECT Device.DeviceId, Device.DeviceName as dname, Room.RoomName as rname FROM Device INNER JOIN Room ON Device.RoomNumber = Room.RoomNumber";

        $req = $connection->prepare($query);

        $req->execute();

        $data = [];

        while ($row = $req->fetch(\PDO::FETCH_ASSOC)) {
            $data[] = array(
                "id" => $row['DeviceId'],
                "name" => $row['dname'],
                "room" => $row['rname']
            );
        }
        $payload = json_encode($data);

        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json');
    }

    /*
     * Fonction qui retourne toutes les informations d'un device à l'aide de son Id
     */
    public function getDeviceById (Request $request, Response $response, $args) {

        $db = new Database();
        $connection  = $db->getConnection();

        $query = "SELECT Device.DeviceId, Device.DeviceName as dname, Room.RoomName as rname 
FROM Device INNER JOIN Room ON Device.RoomNumber = Room.RoomNumber WHERE Device.DeviceId LIKE :id";

        $req = $connection->prepare($query);

        $req->bindParam(':id', $args['id']);

        $req->execute();

        $data = [];

        while ($row = $req->fetch(\PDO::FETCH_ASSOC)) {
            $data[] = array(
                "id" => $row['DeviceId'],
                "name" => $row['dname'],
                "room" => $row['rname']
            );
        }
        $payload = json_encode($data);

        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json');
    }

    /*
     * Fonction qui retourne toutes les mesures d'un device à l'aide de son Id
     */
    public function getDeviceMeasuresById (Request $request, Response $response, $args) {
        $response->getBody()->write('Le device '. $args['id']. ' indique une chaleur de 17° et une humidité de 30%');
        return $response;
    }
}
