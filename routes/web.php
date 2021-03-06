<?php

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

$router->get('/employees', 'EmployeeController@index');
$router->post('/employees', 'EmployeeController@store');
$router->get('/employees/{id}', 'EmployeeController@show');
$router->put('/employees/{id}', 'EmployeeController@update');
$router->patch('/employees/{id}', 'EmployeeController@update');
$router->delete('/employees/{id}', 'EmployeeController@destroy');

$router->get('/applicants', 'ApplicantController@index');
$router->post('/applicants', 'ApplicantController@store');
$router->get('/applicants/{id}', 'ApplicantController@show');
$router->put('/applicants/{id}', 'ApplicantController@update');
$router->patch('/applicants/{id}', 'ApplicantController@update');
$router->delete('/applicants/{id}', 'ApplicantController@destroy');

