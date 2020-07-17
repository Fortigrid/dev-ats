<?php

use Illuminate\Support\Facades\Route;

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


Route::group(['middleware' => 'web'], function() {
Route::get('/', function(){
	return view ('welcome');
});

//Route::get('/{any}', 'SinglePageController@index')->where('any', '^(?!login|register|home|welcome|logout|password|api).*$');
//Route::post('/{any}', 'SinglePageController@index')->where('any', '^(?!login|register|home|welcome|logout|password|api).*$');
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::post('/home', 'HomeController@getval');
Route::resource('/business', 'BusinessUnitController');
Route::resource('/location', 'LocationController');
Route::resource('/role', 'RoleController');
Route::resource('/client', 'ClientController');
Route::resource('/site', 'SiteController');
Route::resource('/agency', 'AgencyController');

});