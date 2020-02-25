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
                "Température" => $row['mTemp'],
                "Humidité" => $row['mHum'],
                "Time" => date('Y-m-d H:i:s', $row['mTime'])
            );
        }
        $payload = json_encode($data);

        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json');
    }

    /*
     * Fonction qui retourne toutes les informations d'un message à l'aide de son ID
     */
    public function getMessageById (Request $request, Response $response, $args) {
            $response->getBody()->write('le message numéro '. $args['id']. ' indique 0e1a');
            return $response;
        }
}