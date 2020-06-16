<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


use App\API\V1\Controllers\IndexController;
use App\API\v1\Controllers\Authentication\AuthenticationController;
use App\Http\Controllers\DataController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

$api = app('Dingo\Api\Routing\Router');


$params = [
    'version' => 'v1',
    'domain' => env('APP_DOMAIN'), // Notice we use the domain WITHOUT port number
    'middleware' => ['jwt.verify']
];

$api->version('v1', function ($api) {
    $api->get('/', IndexController::class . '@getIndex');
    $api->post('/register', AuthenticationController::class . '@register');
    $api->post('/authenticate', AuthenticationController::class . '@authenticate');
});

$api->group($params, function ($api) {

    $api->get('closed', DataController::class . '@closed');
});
