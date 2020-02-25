<?php


namespace App\Application\Object;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;


class Message
{
    /*
     * Fonction qui retourne tous les messages
     */
    public function getAllMessage (Request $request, Response $response, $args) {
        $response->getBody()->write('message 1 : 101e');
        return $response;
    }

    /*
     * Fonction qui retourne toutes les informations d'un message à l'aide de son ID
     */
    public function getMessageById (Request $request, Response $response, $args) {
            $response->getBody()->write('le message numéro '. $args['id']. ' indique 0e1a');
            return $response;
        }
}