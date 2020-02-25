<?php
declare(strict_types=1);

use App\Application\Actions\User\ListUsersAction;
use App\Application\Actions\User\ViewUserAction;
use App\Application\Object\Hello;
use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;

return function (App $app) {
    $app->get('/', Hello::class . ':world');
    $app->get('/hello/{id}', Hello::class . ':worldWId');

    $app->get('/devices/{id}/measures', Device::class . ':getMeasures');
};
