<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('/index', 'WelcomeController@index');
Route::get('/graph', 'WelcomeController@graph');
Route::get('/data.json', 'WelcomeController@jsonData');

Route::get('/add/{id?}', 'WelcomeController@add');
Route::post('/add/{id?}', ['as' => 'add', 'uses' => 'WelcomeController@add']);

Route::get('/path/{id?}', 'WelcomeController@path');
Route::post('/path/{id?}', ['as' => 'path', 'uses' => 'WelcomeController@path']);

Route::get('/ssh/exec', 'WelcomeController@sshExec');

Route::get('/generate/{id?}', 'ConfigController@generateConfig');
Route::get('/generateAll', 'ConfigController@generateConfigAll');
Route::get('/show/{id?}', 'ConfigController@showConfig');
Route::get('/showAll/{id?}', 'ConfigController@showConfigAll');

Route::get('/vpls', 'ConfigController@vplsView');
Route::post('/vpls', ['as' => 'vpls', 'uses' => 'ConfigController@vplsView']);
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::group(['middleware' => ['web']], function () {
    //
});
