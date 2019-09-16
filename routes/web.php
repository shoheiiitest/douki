<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Route::get('/', function () {
//    return view('welcome');
//});
Route::get('/', 'ProjectsController@index');
Route::get('/projects/create', 'ProjectsController@create');
Route::get('/sheets/{project_id}', 'SheetsController@index');
Route::get('/cases/{project_id}/{sheet_id}', 'TestcasesController@index');
Route::get('/create', 'TestcasesController@create');
