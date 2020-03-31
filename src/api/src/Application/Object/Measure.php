<?php


namespace App\Application\Object;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;


class Measure
{
    /*
     * Fonction qui retourne tous les messages
     */
    public function getAllMeasure (Request $request, Response $response, $args) {

        $db = new Database();
        $connection  = $db->getConnection();

        $query = "SELECT Measure.MeasureId as mId, Measure.MeasureTemperature as mTemp, Measure.MeasureHumidity as mHum, 
Measure.MeasureTime as mTime FROM Measure";

        $req = $connection->prepare($query);

        $req->execute();

        $data = [];

        while ($row = $req->fetch(\PDO::FETCH_ASSOC)) {
            $data[] = array(
                "Id" => $row['mId'],
                "Temperature" => $row['mTemp'],
                "Humidity" => $row['mHum'],
                "Time" => $row['mTime']
            );
        }
        $payload = json_encode($data);

        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json');
    }

    /*
     * Fonction qui retourne toutes les informations d'un message à l'aide de son ID
     */
    public function getMeasureById (Request $request, Response $response, $args) {

        $db = new Database();
        $connection  = $db->getConnection();

        $query = "SELECT Measure.MeasureId as mId, Measure.MeasureTemperature as mTemp, Measure.MeasureHumidity as mHum, 
Measure.MeasureTime as mTime, Device.DeviceName as dName FROM Measure INNER JOIN Device ON Measure.DeviceId = Device.DeviceId WHERE Measure.MeasureId = :id";

        $req = $connection->prepare($query);

        $req->bindParam(':id', $args['id']);

        $req->execute();

        $data = [];

        while ($row = $req->fetch(\PDO::FETCH_ASSOC)) {
            $data[] = array(
                "Id" => $row['mId'],
                "Temperature" => $row['mTemp'],
                "Humidity" => $row['mHum'],
                "Time" => date('Y-m-d H:i:s', $row['mTime']),
                "Device Name" => $row['dName']
            );
        }
        $payload = json_encode($data);

        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json');
    }
}