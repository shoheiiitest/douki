<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
Route::get('{project_id}/headers/getItems/', 'HeadersController@getItems');
Route::post('headers/submitHeaders/', 'HeadersController@submitHeaders');
Route::post('headers/editDispFlg/', 'HeadersController@editDispFlg');
Route::post('headers/moveOrder/', 'HeadersController@moveOrder');
Route::get('headers/getColTypes/{mode}/{header_id?}', 'HeadersController@getColTypes');
Route::post('project/delete/', 'ProjectsController@delete');
Route::post('cases/submit', 'TestcasesController@submit');
Route::post('projects/submit', 'ProjectsController@submit');
Route::post('headers/submit', 'HeadersController@submit');
Route::post('sheets/submit', 'SheetsController@submit');
Route::get('sheets/getItems/{mode}/{project_id}/{sheet_id?}', 'SheetsController@getItems');
Route::post('sheets/import', 'SheetsController@import');
//Route::group(['prefix' => 'api'], function () {
//    Route::get('cases/getItems/{project_id}/{sheet_id}', 'TestcasesController@index');
//});
