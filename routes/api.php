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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::resource('/recipe', 'RecipeController');
Route::post('/recipe/list', 'RecipeController@index');
Route::get('/edamam', 'EdamamAPIController@get_request');
Route::post('/recipe/search', 'RecipeController@edamam_search');

