<?php
declare(strict_types=1);

use App\Application\Actions\User\ListUsersAction;
use App\Application\Actions\User\ViewUserAction;
use App\Application\Object\Device;
use App\Application\Object\Measure;
use App\Application\Object\Room;
use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;

return function (App $app) {

    $app->get('/devices', Device::class . ':getAllDevice');
    $app->get('/devices/{id}', Device::class . ':getDeviceById');
    $app->get('/devices/{id}/measures', Device::class . ':getDeviceMeasuresById');

    $app->get('/message', Measure::class . ':getAllMessage');
    $app->get('/message/{id}', Measure::class . ':getMessageById');

    $app->get('/room', Room::class . ':getAllRoom');
    $app->get('/room/{id}', Room::class . ':getRoomById');
    $app->get('/room/{id}/measures', Room::class . ':getRoomMeasuresById');

};
