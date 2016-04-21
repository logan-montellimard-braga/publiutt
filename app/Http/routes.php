<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', ['as' => 'root', function () {
    return view('welcome');
}]);

Route::get('/organisations', 'OrganisationController@index');
Route::post('/organisations', 'OrganisationController@store');
Route::delete('/organisations/{organisation}', 'OrganisationController@destroy');

Route::get('/equipes', 'EquipeController@index');
Route::post('/equipes', 'EquipeController@store');
Route::delete('/equipes/{equipe}', 'EquipeController@destroy');

Route::get('/auteurs', 'AuteurController@index');
Route::get('/auteurs/{auteur}', 'AuteurController@show');
Route::post('/auteurs', 'AuteurController@store');
Route::delete('/auteurs/{auteur}', 'AuteurController@destroy');

Route::get('/publications', 'PublicationController@index');
Route::get('/publications/new', 'PublicationController@new');
Route::post('/publications', 'PublicationController@store');
Route::delete('/publications/{publication}', 'PublicationController@destroy');

Route::auth();
