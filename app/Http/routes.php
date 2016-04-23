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

Route::get('/', ['as' => 'root', 'uses' => 'HomeController@welcome']);

Route::get('/organisations', 'OrganisationController@index');
Route::get('/organisations/show/{organisation}', 'OrganisationController@show');
Route::post('/organisations', 'OrganisationController@store');
Route::delete('/organisations/{organisation}', 'OrganisationController@destroy');

Route::get('/equipes', 'EquipeController@index');
Route::get('/equipes/show/{equipe}', 'EquipeController@show');
Route::post('/equipes', 'EquipeController@store');
Route::delete('/equipes/{equipe}', 'EquipeController@destroy');

Route::get('/auteurs', 'AuteurController@index');
Route::get('/auteurs/show/{auteur}', 'AuteurController@show');
Route::post('/auteurs', 'AuteurController@store');
Route::delete('/auteurs/{auteur}', 'AuteurController@destroy');

Route::get('/publications', ['as' => 'publications', 'uses' => 'PublicationController@index']);
Route::get('/publications/show/{publication}', ['as' => 'publications_show', 'uses' => 'PublicationController@show']);
Route::get('/publications/new', ['as' => 'publications_new', 'middleware' => 'auth', 'uses' => 'PublicationController@create']);
Route::get('/publications/edit/{publication}', ['as' => 'publications_edit', 'middleware' => 'auth', 'uses' => 'PublicationController@edit']);
Route::patch('/publications/edit/{publication}', ['middleware' => 'auth', 'uses' => 'PublicationController@update']);
Route::post('/publications', ['middleware' => 'auth', 'uses' => 'PublicationController@store']);
Route::delete('/publications/{publication}', ['middleware' => 'auth', 'uses' => 'PublicationController@destroy']);

Route::get('/search', 'SearchController@index');
Route::get('/search/results', 'SearchController@find');

Route::auth();

Route::get('/dashboard', ['as' => 'dashboard', 'middleware' => 'auth', 'uses' => 'HomeController@index']);
