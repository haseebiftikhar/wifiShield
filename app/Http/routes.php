<?php
use Symfony\Component\HttpFoundation\Session\Session;


Route::get('/data',[
	'uses'=>'ClientDataController@showVoltage',
	]);






Route::get('/alert', function (Session $session) {
	$session->set('info','Alert!');
	return redirect()->route('home');
	});


/*=================    END ROUGH =============================================*/
Route::get('/', function () {
    return redirect()->route('home');
	});

Route::get('/home', [
	'uses' => 'HomeController@index',
	'as' => 'home',
	]);


Route::get('/signup', [
	'uses' => '\App\Http\Controllers\AuthController@getSignup',
	'as' => 'auth.signup'
	]);
Route::post('/signup',[
	'uses' => '\App\Http\Controllers\AuthController@postSignup'
	]);


Route::get('/signin', [
	'uses' => '\App\Http\Controllers\AuthController@getSignin',
	'as' => 'auth.signin',
	]);
Route::post('/signin', [
	'uses' => '\App\Http\Controllers\AuthController@postSignin',
	]);


Route::get('/dashbord', [
	'uses' => '\App\Http\Controllers\AuthController@dashbord',
	'as' => 'dashbord',
	]);
Route::post('/dashbord', [
	'uses' => '\App\Http\Controllers\AuthController@dashbord',
	]);


Route::get('/signout', [
	'uses' => '\App\Http\Controllers\AuthController@postSignout',
	'as'=>'signout',
	]);

Route::get('/forgot', [
	'uses' => '\App\Http\Controllers\AuthController@getForgot',
	'as' => 'auth.forgot',
	]);
Route::post('/forgot', [
	'uses' => '\App\Http\Controllers\AuthController@postForgot',
	]);


Route::get('/confirmation/{confirmation_code}',[
	'uses' => '\App\Http\Controllers\AuthController@confirm',
	]);

Route::get('/reset/{confirmation_code}',[
	'uses' => '\App\Http\Controllers\AuthController@resetPassword',
	'as'=> 'auth.passwordreset',
	]);
Route::post('/reset',[
	'uses' => '\App\Http\Controllers\AuthController@postResetPassword',
	'as' => 'reset',
	]);

Route::get('/newdashBoard',[
	'uses'=> 'DashBoardController@getnewdashBoard',
	'as'=>'newdashBoard',
	]);

Route::post('/newdashBoard',[
	'uses'=> 'DashBoardController@postnewdashBoard',
	]);

Route::get('/newdevice',['as'=>'add.device',function (Session $session){
	return view('device',['session'=>$session]);
	}]);


// END POINTS
Route::post('/{api_key}/voltage/{value}',[
	'uses'=>'ApiRequestController@storeVoltage'
	]);

Route::post('/{api_key}/current/{value}',[
	'uses'=>'ApiRequestController@storeCurrent'
	]);

Route::post('/{api_key}/power/{value}',[
	'uses'=>'ApiRequestController@storePower'
	]);

