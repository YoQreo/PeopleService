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


$router->get('/employees/pagination', ['as' => 'paginationEmployee', 'uses' =>'EmployeeController@pagination']);
$router->get('/employees/search', ['as' => 'searchEmployee', 'uses' =>'EmployeeController@search']);
$router->get('/employees', ['as' => 'showAllEmployees','uses'=>'EmployeeController@index']);
$router->post('/employees', ['as' => 'createEmployee', 'uses' =>'EmployeeController@store']);
$router->get('/employees/{id}',['as' => 'showAnEmployee', 'uses' => 'EmployeeController@show']);
$router->put("/employees/{id}",['as' => 'updateAnEmployee', 'uses' => 'EmployeeController@update']);
$router->patch("/employees/{id}",['as' => 'updateAnEmployee', 'uses' => 'EmployeeController@update']);
$router->delete("/employees/{id}", ['as' => 'deleteAnEmployee', 'uses' => 'EmployeeController@destroy']);



$router->get('/applicants/search', ['as' => 'searchApplicant', 'uses' =>'ApplicantController@search']);
$router->get('/applicants', 'ApplicantController@index');
$router->post('/applicants', 'ApplicantController@store');
$router->get('/applicants/{id}', 'ApplicantController@show');
$router->put('/applicants/{id}', 'ApplicantController@update');
$router->patch('/applicants/{id}', 'ApplicantController@update');
$router->delete('/applicants/{id}', 'ApplicantController@destroy');

