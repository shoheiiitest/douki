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

// Route::get('/home', function () {
//    return view('welcome');
// });
Auth::routes();
Route::group(['middleware' => ['web', 'auth']], function () {
    Route::get('/', 'ProjectsController@index');
    Route::get('/projects/create', 'ProjectsController@create');
    Route::get('{project_id}/headers/list', 'HeadersController@list');
    Route::get('{project_id}/header/create', 'HeadersController@create');
    Route::get('{project_id}/header/edit/{header_id}', 'HeadersController@edit');
    Route::get('/sheets/create/{project_id}', 'SheetsController@create');
    Route::get('/sheets/edit/{project_id}/{sheet_id}', 'SheetsController@edit');
    Route::get('/sheets/{project_id}', 'SheetsController@index');
    Route::get('/cases/{project_id}/{sheet_id}', 'TestcasesController@index');
    Route::get('/create', 'TestcasesController@create');

Route::get('/sheet/export/{project_id}/{sheet_id}', 'SheetsController@export');
});

//logout
Route::get('/logout','LogoutController@logout');