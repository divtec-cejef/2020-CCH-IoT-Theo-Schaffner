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
        if ($req->rowCount() > 0) {
            $result = $req->fetchAll(\PDO::FETCH_ASSOC);

            $data = [
                "id" => $result[0]['DeviceId'],
                "name" => $result[0]['dname'],
                "room" => $result[0]['rname']
            ];

        } else {
            $payload = json_encode(array(
                "error" => [
                    "code" => 404,
                    "message" => "device not found"
                ]
            ));
            $response->getBody()->write($payload);
            return $response->withHeader('Content-Type', 'application/json')->withStatus(404);
        }

        $payload = json_encode($data);

        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json');
    }

    /*
     * Fonction qui retourne toutes les mesures d'un device à l'aide de son Id
     */
    public function getDeviceMeasuresById (Request $request, Response $response, $args) {

        $db = new Database();
        $connection  = $db->getConnection();

        $query = "SELECT Measure.MeasureId, Measure.MeasureTemperature as mTemp, Measure.MeasureHumidity as mHum, 
Measure.MeasureTime as mTime FROM Measure WHERE Measure.DeviceId LIKE :id";

        $req = $connection->prepare($query);

        $req->bindParam(':id', $args['id']);

        $req->execute();

        $data = [];

        while ($row = $req->fetch(\PDO::FETCH_ASSOC)) {
            $data[] = array(
                "id" => $row['MeasureId'],
                "Température" => $row['mTemp'],
                "Humidité" => $row['mHum'],
                "Temps" => date('Y-m-d H:i:s', $row['mTime'])
            );
        }
        $payload = json_encode($data);

        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json');
    }
}
