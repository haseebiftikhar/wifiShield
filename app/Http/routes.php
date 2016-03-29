<?php
use Symfony\Component\HttpFoundation\Session\Session;

Route::get('/{mac_address}/voltage/{value}',[
	'uses'=>'ClientDataController@storeVoltage'
	]);

Route::get('/{mac_address}/current/{value}',[
	'uses'=>'ClientDataController@storeCurrent'
	]);

Route::get('/{mac_address}/power/{value}',[
	'uses'=>'ClientDataController@storePower'
	]);

/*=================     ROUGH   ==================================*/

Route::get('/here',[
	'uses'=> 'DashBoardController@getForecast',
	'as'=>'here',
	]);
Route::post('/here',[
	'uses'=> 'DashBoardController@getForecast',
	]);



Route::get('/guzzle1', [
	'uses' => 'GuzzleController@get_git',
	]);

Route::get('/abc', [
	'uses' => 'ChartController@getChart',
	]);

Route::get('/weather', [
	'uses' => 'WeatherController@getWeather',
	]);

Route::get('/weatherForecast/{city}', [
	'uses' => 'WeatherController@weatherForecast',
	]);

Route::get('/displayForecast/{city}', [
	'uses' => 'WeatherChart@getWeather',
	]);


Route::get('/guzzle', function () {
    $client = new GuzzleHttp\Client();
    $response = $client->get('https://api.github.com/users/haseebiftikhar');
    return $response->getBody();
});

Route::get('users/{username}', function($username)
{
    $client = new GuzzleHttp\Client([
        'base_uri' => 'https://api.github.com/']);

    $res = $client->get("users/$username");

    //echo $res->getStatusCode();
    var_dump($res->getStatusCode());

    echo $res->getBody();
});

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
	return view('dashbord',['session'=>$session]);
	}]);

