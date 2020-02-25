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
        $response->getBody()->write('Salle 1 : B1-01');
        return $response;
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