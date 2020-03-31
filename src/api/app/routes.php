<?php

use App\Application\Actions\User\ListUsersAction;
use App\Application\Actions\User\ViewUserAction;
use App\Application\Object\Device;
use App\Application\Object\Measure;
use App\Application\Object\Room;
use App\Application\Object\Callback;
use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;

return function (App $app) {

    $app->get('/IoT/api/devices', Device::class . ':getAllDevice');
    $app->get('/IoT/api/devices/{id}', Device::class . ':getDeviceById');
    $app->get('/IoT/api/devices/{id}/measures', Device::class . ':getDeviceMeasuresById');

    $app->get('/IoT/api/measures', Measure::class . ':getAllMeasure');
    $app->get('/IoT/api/measures/{id}', Measure::class . ':getMeasureById');

    $app->get('/IoT/api/rooms', Room::class . ':getAllRoom');
    $app->get('/IoT/api/rooms/{id}', Room::class . ':getRoomById');

    $app->post('/IoT/api/callback', Callback::class . ':callback');
};
