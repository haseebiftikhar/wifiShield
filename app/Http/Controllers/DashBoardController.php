<?php
namespace App\Http\Controllers;

use Cmfcmf\OpenWeatherMap;
use Khill\Lavacharts\Lavacharts;
use Khill\Lavacharts\Laravel\LavachartsFacade as Lava;

use Symfony\Component\HttpFoundation\Session\Session;
use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\MacAddress;

//use Auth;

Class DashBoardController extends Controller
{
	public function getnewdashBoard(Session $session)
	{
		var_dump($session->get('email'));
		$client = Client::whereEmail($session->get('email'))->first();
		$devices = MacAddress::whereUserId($client->id)->count();
		//dd($devices[0]->mac_address);
		if($devices == 0)
		{
			return view('dashbord',['session'=>$session]);
		}
		return redirect()->route('here');
	}

	public function postnewdashBoard(Request $request,Session $session)
	{	
		$this->validate($request, [
			'mac_address' => 'required',
		]);

		$client = Client::whereEmail($session->get('email'))->first();
		
		MacAddress::create([
			'user_id'=> $client->id,
			'mac_address'=>$request->input('mac_address'),
		]);
		return redirect()->route('newdashBoard');
	}

	public function getForecast(Request $request,Session $session)
	{
		$city = 'Lahore';//$request->input('city');
		if ($request->input('city')) {
			$city = $request->input('city');
		}

		$client = Client::whereEmail($session->get('email'))->first();
		$key = $client->mac_address;
		var_dump('U reasched your Limit fall back'); //====================================================== HERE
		exit();
		//dd($client);
		$lang = 'en';
		// Units (can be 'metric' or 'imperial' [default]):
		$units = 'metric';
		// Get OpenWeatherMap object. Don't use caching (take a look into Example_Cache.php to see how it works).
		$owm = new OpenWeatherMap('233dbc9c54dbc84eebcaefb852319715');
		// Example 1: Get forecast for the next 10 days for Berlin.
		$forecast = $owm->getWeatherForecast($city, $units, $lang, '', 10);

		foreach ($forecast as $weather)
		{
			$temp = (array) $weather->time->to;
			$temp_val = explode(' ', $temp['date']);
			$date[] = $temp_val[0];

			$val = (array)$weather->temperature;
			$value = (array) $val['now'];
			$value1 = array_pop($value);
			$value2 = array_pop($value);
			$temperature[] = array_pop($value);
		}
		
		$reasons = Lava::DataTable();
		$reasons->addStringColumn('Date')
		        ->addNumberColumn('°C')
		        ->addRow([$date[0], $temperature[1]])
		        ->addRow([$date[1], $temperature[1]])
		        ->addRow([$date[2], $temperature[2]])
		        ->addRow([$date[3], $temperature[3]])
		        ->addRow([$date[4], $temperature[4]])
		        ->addRow([$date[5], $temperature[5]])
		        ->addRow([$date[6], $temperature[6]])
		        ->addRow([$date[7], $temperature[7]])
		        ->addRow([$date[8], $temperature[8]])
		        ->addRow([$date[9], $temperature[9]]);

		$out= Lava::ColumnChart('IMDB', $reasons, [
		    'title' => 'Weather Forecast of '.$weather->city->name,
		    'titleTextStyle' => [
	        'color'    => '#eb6b2c',
	        'fontSize' => 14
	    	]
		]);
		//$session->set('info','I am chart bitch');
		return view ('chartView',['IMDB'=>$out, 'session'=>$session]);
	}
}
