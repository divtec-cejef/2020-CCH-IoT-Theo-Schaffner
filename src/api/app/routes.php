<?php
declare(strict_types=1);

use App\Application\Actions\User\ListUsersAction;
use App\Application\Actions\User\ViewUserAction;
use App\Application\Object\Device;
use App\Application\Object\Measure;
use App\Application\Object\Room;
use App\Application\Object\Callback;
use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;

return function (App $app) {

    $app->get('/devices', Device::class . ':getAllDevice');
    $app->get('/devices/{id}', Device::class . ':getDeviceById');
    $app->get('/devices/{id}/measures', Device::class . ':getDeviceMeasuresById');

    $app->get('/measures', Measure::class . ':getAllMeasure');
    $app->get('/measures/{id}', Measure::class . ':getMeasureById');

    $app->get('/rooms', Room::class . ':getAllRoom');
    $app->get('/rooms/{id}', Room::class . ':getRoomById');

    $app->post('/callback', Callback::class . ':callback');
};
