<?php

use App\Application\Actions\User\ListUsersAction;
use App\Application\Actions\User\ViewUserAction;
use App\Application\Object\Measure;
use App\Application\Object\Callback;
use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;

return function (App $app) {

    $app->post('/IoT/api/callback', Callback::class . ':callback');

    $app->get('/IoT/api/measures', Measure::class . ':getMeasures');
    $app->get('/IoT/api/measures/{from}/{to}', Measure::class . ':getMeasuresFromTo');
    $app->put('/IoT/api/measures/{id:[0-9]+}', Measure::class . ':updateMeasures');
    $app->delete('/IoT/api/measures/{id:[0-9]+}', Measure::class . ":deleteMeasures");
};
