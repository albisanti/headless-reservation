<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

//Auth
$router->post('/signup','AuthController@signup');
$router->post('/login','AuthController@login');
$router->post('/logout','AuthController@logout');
$router->post('/refresh','AuthController@refresh');
$router->post('/me','AuthController@me');

$router->group(['middleware' => 'auth'], function() use ($router){

    //Rooms
    $router->get('/rooms','RoomController@getRooms');
    $router->get('/room/{id}','RoomController@roomDetail');
    $router->put('/room','RoomController@addRoom');
    $router->patch('/room','RoomController@updateRoom');
    $router->delete('/room','RoomController@removeRoom');

    //Hours
    $router->get('/room/hour/{id}','RoomController@getRoomHours');
    $router->put('/room/hour','RoomController@addDayHour');
    $router->patch('/room/hour','RoomController@updateDayHour');
    $router->delete('/room/hour','RoomController@removeDayHour');

    //Reservations
    $router->put('/reservation','ReservationController@addReservation');
    $router->get('/reservation/room/{room_id}','ReservationController@getRoomsReservations');
    $router->get('/reservation/mine','ReservationController@getMyReservations');
    $router->get('/reservation/user/{id}','ReservationController@getUserReservations');

});
