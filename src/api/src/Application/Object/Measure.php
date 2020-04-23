<?php


namespace App\Application\Object;

use Cassandra\Date;
use DateTime;
use PDO;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class Measure
{
    /**
     * Metier de la route GET /api/measures
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return Response
     * @throws \Exception
     */
    public function getMeasures (Request $request, Response $response, array $args) {
        $today = (new \DateTime())->format('Y-m-d');
        $todayMorning = $today . " 00:00:00";
        $todayEvening = $today . " 23:59:59";

        $req = null;
        try {
            // récupération des mesure
            $query = "SELECT Measure.MeasureId, MeasureTime, MeasureTemperature, MeasureHumidity, DeviceName FROM Measure INNER JOIN Device ON Measure.DeviceId = Device.DeviceId WHERE MeasureTime > '$todayMorning' AND MeasureTime < '$todayEvening' ORDER BY MeasureTime ASC";
            $db = new Database();
            $conn = $db->getConnection();
            $req = $conn->prepare($query);
            $req->setFetchMode(PDO::FETCH_ASSOC);
            $req->execute();
        } catch (\Exception $e) {
            $payload = json_encode(array(
                "error" => [
                    "code" => 500,
                    "message" => "Request fail",
                    "name" => "getRequestFail"
                ]
            ));
            $response->getBody()->write($payload);
            return $response->withHeader('Content-Type', 'application/json')->withStatus(500);
        }

        // récupération des données
        $maxT = -200;
        $minT = 200;
        $lastT = 0;
        $maxH = -200;
        $minH = 200;
        $lastH = 0;
        $lastDate = "";
        $lastId = 0;

        while ($row = $req->fetch()) {
            $maxT = $row["MeasureTemperature"] > $maxT ? $row["MeasureTemperature"] : $maxT;
            $maxH = $row["MeasureHumidity"] > $maxH ? $row["MeasureHumidity"] : $maxH;
            $minT = $row["MeasureTemperature"] < $minT ? $row["MeasureTemperature"] : $minT;
            $minH = $row["MeasureHumidity"] < $minH ? $row["MeasureHumidity"] : $minH;
            $lastT = $row["MeasureTemperature"];
            $lastH = $row["MeasureHumidity"];
            $lastDate = $row["MeasureTime"];
            $lastId = $row["MeasureId"];
        }

        $payload = json_encode(array(
            "temperature" => [
                "max" => $maxT,
                "min" => $minT,
                "last" => $lastT
            ],
            "humidity" => [
                "max" => $maxH,
                "min" => $minH,
                "last" => $lastH
            ],
            "last" => [
                "id" => $lastId,
                "date" => $lastDate,
                "temperature" => $lastT,
                "humidity" => $lastH
            ]
        ));
        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
    }

    public function getMeasuresFromTo (Request $request, Response $response, array $args) {
        // valider les dates Y-m-d
        $from = explode("-", $args["from"]);
        $fromIsValid = checkdate($from[1], $from[2], $from[0]);
        $to = explode("-", $args["to"]);
        $toIsValid = checkdate($to[1], $to[2], $to[0]);
        if ($fromIsValid && $toIsValid) {
            $from = $args["from"];
            $to = $args["to"];

            $fromMorning = $from . " 00:00:00";
            $fromEvening = $from . " 23:59:59";
            $toMorning = $to . " 00:00:00";
            $toEvening = $to . " 23:59:59";

            $req = null;

            try {
                $query = "SELECT Measure.Measureid, MeasureTime, MeasureTemperature, MeasureHumidity, DeviceName FROM Measure INNER JOIN Device ON Measure.DeviceId = Device.DeviceId WHERE MeasureTime > '$fromMorning' AND MeasureTime < '$toEvening' ORDER BY MeasureTime ASC";
                $db = new Database();
                $conn = $db->getConnection();
                $req = $conn->prepare($query);
                $req->setFetchMode(PDO::FETCH_ASSOC);
                $req->execute();
            } catch (\PDOException $e) {
                $payload = json_encode(array(
                    "error" => [
                        "code" => 500,
                        "message" => "Request fail",
                        "name" => "getRequestFail"
                    ]
                ));
                $response->getBody()->write($payload);
                return $response->withHeader('Content-Type', 'application/json')->withStatus(500);
            }

            $day = new DateTime($fromEvening);
            $data = [];
            $maxT = -200;
            $minT = 200;
            $lastT = 0;
            $maxH = -200;
            $minH = 200;
            $lastH = 0;

            while ($row = $req->fetch()) {
                $dbtime = new DateTime($row['MeasureTime']);
                if ($dbtime < $day) {
                    $maxT = $row["MeasureTemperature"] > $maxT ? $row["MeasureTemperature"] : $maxT;
                    $maxH = $row["MeasureHumidity"] > $maxH ? $row["MeasureHumidity"] : $maxH;
                    $minT = $row["MeasureTemperature"] < $minT ? $row["MeasureTemperature"] : $minT;
                    $minH = $row["MeasureHumidity"] < $minH ? $row["MeasureHumidity"] : $minH;
                    $lastT = $row["MeasureTemperature"];
                    $lastH = $row["MeasureHumidity"];
                } else {
                    // add to data
                    $data[] = array(
                        "temperature" => [
                            "max" => $maxT,
                            "min" => $minT,
                            "last" => $lastT
                        ],
                        "humidity" => [
                            "max" => $maxH,
                            "min" => $minH,
                            "last" => $lastH
                        ],
                        "date" => $day->format("Y-m-d")
                    );
                    $maxT = -200;
                    $minT = 200;
                    $lastT = 0;
                    $maxH = -200;
                    $minH = 200;
                    $lastH = 0;
                    $day->modify('+1 day');
                }
            }
            $data[] = array(
                "temperature" => [
                    "max" => $maxT,
                    "min" => $minT,
                    "last" => $lastT
                ],
                "humidity" => [
                    "max" => $maxH,
                    "min" => $minH,
                    "last" => $lastH
                ],
                "date" => $day->format("Y-m-d")
            );

            $response->getBody()->write(json_encode($data));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
        }
        $response->getBody()->write(json_encode(["error" => [
            "code" => 412,
            "Message" => "You dont have valid dates"
        ]]));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(412);
    }

    public function updateMeasures (Request $request, Response $response, array $args) {
        $MeasureId = $args['id'];
        parse_str(file_get_contents("php://input"),$_PUT);

        if (isset($_PUT['MeasureTemperature']) && isset($_PUT['MeasureHumidity'])) {
            try {
                $query = "UPDATE Measure SET MeasureTemperature = :temp, MeasureHumidity = :hum WHERE MeasureId = :id";
                $db = new Database();
                $conn = $db->getConnection();
                $req = $conn->prepare($query);
                $req->bindParam(":temp", $_PUT['MeasureTemperature']);
                $req->bindParam(":hum", $_PUT['MeasureHumidity']);
                $req->bindParam(":id", $MeasureId);
                $req->setFetchMode(PDO::FETCH_ASSOC);
                $req->execute();
            } catch (\PDOException $e) {
                $payload = json_encode(array(
                    "error" => [
                        "code" => 500,
                        "message" => "Request fail",
                        "name" => "getRequestFail"
                    ]
                ));
                $response->getBody()->write($payload);
                return $response->withHeader('Content-Type', 'application/json')->withStatus(500);
            }
            $response->getBody()->write(json_encode([
                "MeasureTemperature" => $_PUT['MeasureTemperature'],
                "MeasureHumidity" => $_PUT['MeasureHumidity'],
                "MeasureId" => $MeasureId
            ]));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
        }
        $response->getBody()->write(json_encode(["error" => [
            "code" => 412,
            "Message" => "You dont have valid dates"
        ]]));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(412);
    }

    public function deleteMeasures (Request $request, Response $response, array $args) {
        $MeasureId = $args['id'];

        try {
            $query = "DELETE FROM Measure WHERE MeasureId = :MeasureId";
            $db = new Database();
            $conn = $db->getConnection();
            $req = $conn->prepare($query);
            $req->bindParam(":MeasureId", $MeasureId);
            $req->setFetchMode(PDO::FETCH_ASSOC);
            $req->execute();
        } catch (\PDOException $e) {
            $payload = json_encode(array(
                "error" => [
                    "code" => 500,
                    "message" => "Request fail",
                    "name" => "getRequestFail"
                ]
            ));
            $response->getBody()->write($payload);
            return $response->withHeader('Content-Type', 'application/json')->withStatus(500);
        }

        $response->getBody()->write(json_encode(["MeasureId" => $MeasureId]));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
    }
}