<?php


namespace App\Application\Object;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;


class Device
{
    /*
     * Fonction qui retourne tous les device de la base de donnée
     */
    public function getAllDevice (Request $request, Response $response, $args) {
        $response->getBody()->write('Device 1 : MKR-FOX-SCHATHE');
        return $response;
    }

    /*
     * Fonction qui retourne toutes les informations d'un device à l'aide de son Id
     */
    public function getDeviceById (Request $request, Response $response, $args) {
        $response->getBody()->write('Le device '. $args['id']. ' se nomme MKR-FOX-...');
        return $response;
    }

    /*
     * Fonction qui retourne toutes les mesures d'un device à l'aide de son Id
     */
    public function getDeviceMeasuresById (Request $request, Response $response, $args) {
        $response->getBody()->write('Le device '. $args['id']. ' indique une chaleur de 17° et une humidité de 30%');
        return $response;
    }
}
