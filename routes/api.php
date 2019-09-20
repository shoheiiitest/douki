<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('cases/getItems/{project_id}/{sheet_id}', 'TestcasesController@getItems');
Route::get('projects/getItems/', 'ProjectsController@getItems');
Route::post('project/delete/', 'ProjectsController@delete');
Route::post('cases/submit', 'TestcasesController@submit');
Route::post('projects/submit', 'ProjectsController@submit');
Route::post('sheets/submit', 'SheetsController@submit');
Route::get('sheets/getHeaders/{project_id}', 'SheetsController@getHeaders');
//Route::group(['prefix' => 'api'], function () {
//    Route::get('cases/getItems/{project_id}/{sheet_id}', 'TestcasesController@index');
//});
