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
Route::get('/organisations/edit/{organisation}', ['uses' => 'OrganisationController@edit', 'middleware' => 'auth']);
Route::patch('/organisations/edit/{organisation}', ['uses' => 'OrganisationController@update', 'middleware' => 'auth']);
Route::post('/organisations', ['uses' => 'OrganisationController@store', 'middleware' => 'auth']);
Route::delete('/organisations/{organisation}', ['uses' => 'OrganisationController@destroy', 'middleware' => 'auth']);

Route::get('/equipes', 'EquipeController@index');
Route::get('/equipes/show/{equipe}', 'EquipeController@show');
Route::get('/equipes/edit/{equipe}', ['uses' => 'EquipeController@edit', 'middleware' => 'auth']);
Route::patch('/equipes/edit/{equipe}', ['uses' => 'EquipeController@update', 'middleware' => 'auth']);
Route::post('/equipes', ['uses' => 'EquipeController@store', 'middleware' => 'auth']);
Route::delete('/equipes/{equipe}', ['uses' => 'EquipeController@destroy', 'middleware' => 'auth']);

Route::get('/auteurs', 'AuteurController@index');
Route::get('/auteurs/show/{auteur}', 'AuteurController@show');
Route::get('/auteurs/edit/{auteur}', ['uses' => 'AuteurController@edit', 'middleware' => 'auth']);
Route::patch('/auteurs/edit/{auteur}', ['uses' => 'AuteurController@update', 'middleware' => 'auth']);
Route::post('/auteurs', ['uses' => 'AuteurController@store', 'middleware' => 'auth']);
Route::delete('/auteurs/{auteur}', ['uses' => 'AuteurController@destroy', 'middleware' => 'auth']);

Route::get('/publications', ['as' => 'publications', 'uses' => 'PublicationController@index']);
Route::get('/publications/show/{publication}', ['as' => 'publications_show', 'uses' => 'PublicationController@show']);
Route::get('/publications/new', ['as' => 'publications_new', 'middleware' => 'auth', 'uses' => 'PublicationController@create']);
Route::get('/publications/edit/{publication}', ['as' => 'publications_edit', 'middleware' => 'auth', 'uses' => 'PublicationController@edit']);
Route::patch('/publications/edit/{publication}', ['middleware' => 'auth', 'uses' => 'PublicationController@update']);
Route::post('/publications', ['middleware' => 'auth', 'uses' => 'PublicationController@store']);
Route::delete('/publications/{publication}', ['middleware' => 'auth', 'uses' => 'PublicationController@destroy']);

Route::get('/statuts/show/{statut}', 'StatutController@show');
Route::get('/categories/show/{categorie}', 'CategorieController@show');

Route::get('/search', 'SearchController@index');
Route::get('/search/results', 'SearchController@find');

Route::auth();

Route::get('/dashboard', ['as' => 'dashboard', 'middleware' => 'auth', 'uses' => 'HomeController@index']);
Route::get('/profil', ['as' => 'profil', 'middleware' => 'auth', 'uses' => 'HomeController@profile']);
Route::get('/profil/edit', ['as' => 'profile_edit', 'middleware' => 'auth', 'uses' => 'HomeController@editProfile']);

Route::patch('/users/switch_admin/{user}', ['middleware' => 'auth', 'uses' => 'UserController@switchAdmin']);
Route::patch('/users/edit/{user}', ['middleware' => 'auth', 'uses' => 'UserController@update']);
