<?php


namespace App\Application\Object;

use PDO;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class Callback
{
    public function callback(Request $request, Response $response, $args)
    {
        $id = $_POST['id'];
        $time = $_POST['time'];
        $temphum = $_POST['data'];

        $temp = hexdec(substr($temphum, 0, 2));
        $hum = hexdec(substr($temphum, -2, 2));

        if (isset($id) && isset($time) && isset($temp) && isset($hum)) {
            $this->insertDeviceAndData($id, $time, $temp, $hum);
        }
        $data = array(
            "id" => $id,
            "time" => $time,
            "humidity" => $hum,
            "temperature" => $temp
        );

        $payload = json_encode($data);

        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json');

    }

    private function insertDeviceAndData($id, $time, $temp, $hum)
    {
        // insertion des données dans la base de données
        $db = new Database();
        $connection = $db->getConnection();

        $query = "INSERT IGNORE INTO Device VALUES(null, :device, 4);";

        $req = $connection->prepare($query);

        $req->bindParam(':device', $id);

        $req->execute();

        $time = date('Y-m-d H:i:s',$time);

        $query = "INSERT INTO Measure VALUES(null, :temp, :hum, :insertTime, 
(SELECT DeviceId FROM Device WHERE DeviceName = :id));";

        $req = $connection->prepare($query);

        $req->bindParam(':temp', $temp);
        $req->bindParam(':hum', $hum);
        $req->bindParam(':insertTime', $time);
        $req->bindParam(':id', $id);

        $req->execute();
    }
}
