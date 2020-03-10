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
    }
}
