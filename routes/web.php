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

Route::get('/', 'GameLogsController@index');
Route::get('/team/{id}', 'TeamsController@showTeam');
Route::get('/player/{id}', 'PlayersController@showPlayer');
Route::get('/gamerecord/{id}', 'GameRecordsController@showGameRecord');

Route::resource('posts','PostsController');
Route::resource('games','GamesController');
Route::resource('players','PlayersController');
Route::resource('teams','TeamsController');
Route::resource('gamelogs','GameLogsController');
Route::resource('gamerecords','GameRecordsController');



Route::post('posts/changeStatus', array('as' => 'changeStatus', 'uses' => 'PostsController@changeStatus'));
Route::post('players/changeStatus', array('as' => 'changeStatus', 'uses' => 'PlayersController@changeStatus'));
Route::post('teams/changeStatus', array('as' => 'changeStatus', 'uses' => 'TeamsController@changeStatus'));
Route::post('games/changeStatus', array('as' => 'changeStatus', 'uses' => 'GamesController@changeStatus'));

Auth::routes();
Route::get('/home', 'HomeController@index');
