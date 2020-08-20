<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Adjob;

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
	return view ('auth.login');
});



//Route::get('/{any}', 'SinglePageController@index')->where('any', '^(?!login|register|home|welcome|logout|password|api).*$');
//Route::post('/{any}', 'SinglePageController@index')->where('any', '^(?!login|register|home|welcome|logout|password|api).*$');
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::post('/home', 'HomeController@getval');
Route::resource('/business', 'BusinessUnitController')->middleware('can:view-user');
Route::resource('/location', 'LocationController')->middleware('can:view-user');
Route::resource('/role', 'RoleController')->middleware('can:view-user');
Route::resource('/client', 'ClientController')->middleware('can:view-user');
Route::resource('/site', 'SiteController')->middleware('can:view-user');
Route::resource('/agency', 'AgencyController')->middleware('can:view-user');
Route::resource('/job-template', 'JobTemplateController')->middleware('can:view-user');
Route::get('/recruitment','AdController@recruit');
Route::get('/recruitment/adpost','AdController@adIndex');
Route::post('/recruitment/adpost','AdController@adIndexPost');
Route::get('/recruitment/adpost/1','AdController@adDetail');
Route::post('/recruitment/adpost/1','AdController@adDetailPost');
Route::get('/recruitment/adpost/2','AdController@previewPub');
Route::post('/recruitment/adpost/2','AdController@previewPubPost');
Route::get('/recruitment/adpost/3','AdController@jobPub');
Route::post('/recruitment/adpost/3','AdController@jobPubPost');
Route::get('/recruitment/managead','AdController@manageAd')->name('mpost');
Route::post('/recruitment/managead','AdController@allAd');
Route::get('/recruitment/managead/{rid}','AdController@displayAd');
Route::get('/recruitment/managead/{rid}/all','AdController@displayAll')->name('dall');
Route::get('/recruitment/managead/{rid}/qual','AdController@displayAll');
Route::get('/recruitment/managead/{rid}/star','AdController@displayAll');
Route::get('/recruitment/managead/{rid}/invite','AdController@displayAll');
Route::post('/recruitment/managead/{rid}/del','AdController@deleteAd');
Route::post('/recruitment/managead/{rid}/statChange','AdController@statChange');
Route::get('/recruitment/managead/{rid}/edit','AdController@editChange');
Route::post('/recruitment/managead/{rid}/edit','AdController@editChangePost');
Route::get('/recruitment/managead/{rid}/edit/step1','AdController@editDetail');
Route::post('/recruitment/managead/{rid}/edit/step1','AdController@editDetailPost');
Route::get('/recruitment/managead/{rid}/edit/step2','AdController@editPub');
Route::post('/recruitment/managead/{rid}/edit/step2','AdController@editPubPost');
Route::get('/recruitment/managead/{rid}/edit/step3','AdController@editJobPub');
Route::post('/recruitment/managead/{rid}/edit/step3','AdController@editJobPubPost');
Route::get('/recruitment/managead/{rid}/resend','AdController@resendChange');
Route::post('/recruitment/managead/{rid}/resend','AdController@resendChangePost');
Route::get('/recruitment/managead/{rid}/resend/step1','AdController@resendDetail');
Route::post('/recruitment/managead/{rid}/resend/step1','AdController@resendDetailPost');
Route::get('/recruitment/managead/{rid}/resend/step2','AdController@resendPub');
Route::post('/recruitment/managead/{rid}/resend/step2','AdController@resendPubPost');
Route::get('/recruitment/managead/{rid}/resend/step3','AdController@resendJobPub');
Route::post('/recruitment/managead/{rid}/resend/step3','AdController@resendJobPubPost');
Route::get('/recruitment/managead/{rid}/repost','AdController@repostChange');
Route::post('/recruitment/managead/{rid}/repost','AdController@repostChangePost');
Route::get('/recruitment/managead/{rid}/repost/step1','AdController@repostDetail');
Route::post('/recruitment/managead/{rid}/repost/step1','AdController@repostDetailPost');
Route::get('/recruitment/managead/{rid}/repost/step2','AdController@repostPub');
Route::post('/recruitment/managead/{rid}/repost/step2','AdController@repostPubPost');
Route::get('/recruitment/managead/{rid}/repost/step3','AdController@repostJobPub');
Route::post('/recruitment/managead/{rid}/repost/step3','AdController@repostJobPubPost');
Route::get('/recruitment/manageappli','ApplicantController@appliIndex')->name('appall');
Route::get('/recruitment/cvsearch','ApplicantController@cvSearch');
Route::get('/response','ApplicantController@responses');
Route::get('/account','ApplicantController@campaign');
});
//URL::forceScheme('https');