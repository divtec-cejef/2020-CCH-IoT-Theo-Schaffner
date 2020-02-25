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

        $db = new Database();
        $connection  = $db->getConnection();

        $query = "SELECT Room.RoomNumber as rNumb, Room.RoomName as rName FROM Room WHERE Room.RoomNumber = :id";

        $req = $connection->prepare($query);

        $req->bindParam(':id', $args['id']);

        $req->execute();

        $data = [];

        if ($req->rowCount() > 0) {
            $result = $req->fetchAll(\PDO::FETCH_ASSOC);

            $data[] = array(
                "Name" => $result[0]['rNumb'],
                "Room" => $result[0]['rName']
            );

        } else {
            $payload = json_encode(array(
                "Error" => [
                    "Code" => 404,
                    "Message" => "Room not found"
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
     * Fonction qui retourne toutes les mesures d'une salle à l'aide de son Id
     */
    public function getRoomMeasuresById (Request $request, Response $response, $args) {

        $db = new Database();
        $connection  = $db->getConnection();

        $query = "SELECT Measure.MeasureId as mId, Measure.MeasureTemperature as mTemp, Measure.MeasureHumidity as mHum, 
Measure.MeasureTime as mTime, Room.RoomName as rName FROM Measure 
INNER JOIN Device ON Measure.DeviceId = Device.DeviceId 
INNER JOIN Room ON Device.RoomNumber = Room.RoomNumber WHERE Room.RoomNumber = :id";

        $req = $connection->prepare($query);

        $req->bindParam(':id', $args['id']);

        $req->execute();

        $data = [];

        while ($row = $req->fetch(\PDO::FETCH_ASSOC)) {
            $data[] = array(
                "Id" => $row['mId'],
                "Temperature" => $row['mTemp'],
                "Humidity" => $row['mHum'],
                "Time" => $row['mTime'],
                "Room Name" => $row['rName']
            );
        }
        $payload = json_encode($data);

        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json');
    }
}