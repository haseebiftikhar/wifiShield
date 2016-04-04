<?php
namespace App\Http\Controllers;

use Cmfcmf\OpenWeatherMap;
use Khill\Lavacharts\Lavacharts;
use Khill\Lavacharts\Laravel\LavachartsFacade as Lava;

use Symfony\Component\HttpFoundation\Session\Session;
use Illuminate\Http\Request;
//use Carbon\Carbon;

use App\Models\Client;
use App\Models\Voltage;
use App\Models\MacAddress;
// use App\Models\Current;
// use App\Models\Power;
//


Class ClientDataController extends Controller
{
	public function date()
	{
		$date = new \DateTime();
		var_dump($date->format('Y-m-d'));
		$hours = $date->format('h:i A');
		var_dump($hours);
		$date->modify('-1 day');
		var_dump($date);
	}
	public function showVoltage (Session $session)
	{
		$session->set('email' , 'haseeb@brokergenius.com');

		$client = Client::whereEmail($session->get('email'))->first();

		$mac_address = MacAddress::whereUserId($client->id)->get();
		
		foreach ($mac_address as $variable) {
			$mac[]=$variable->mac_address;
		}
		// Here i am =============================================================================================//    
		$voltages = \DB::table('voltages')->where('mac_address', $mac[1])->lists('voltage');

		foreach ($voltages as $voltage) {
			var_dump($voltage);
		}
		exit();
		$date = new \DateTime();
		$timeStemp = $date->getTimestamp();

		$results = Voltage::where('user_id', $client->id)
						  ->where('date','>','1459533185')
						  ->where('date','<',$timeStemp)
						  ->get();

		$voltages = Lava::DataTable();
		$voltages->addDateColumn('Date')
		         ->addNumberColumn('Max Temp');

		foreach ($results as $result) {
			//var_dump($result->voltage);
			$date->setTimestamp($result->date);
			var_dump($date->format('Y-m-d H:i:s'));

			$voltages->addRow([$date->format('H:i:s'),  $result->voltage]);
		}


/*
		$voltages = Lava::DataTable();

		$voltages->addDateColumn('Date')
		             ->addNumberColumn('Max Temp')
		             ->addRow(['2014-10-1',  67])		             ->addRow(['2014-10-2',  68])
		             ->addRow(['2014-10-3',  68])
		             ->addRow(['2014-10-4',  72])
		             ->addRow(['2014-10-5',  61])
		             ->addRow(['2014-10-6',  70])
		             ->addRow(['2014-10-7',  74])
		             ->addRow(['2014-10-8',  75])
		             ->addRow(['2014-10-9',  69])
		             ->addRow(['2014-10-10', 64])
		             ->addRow(['2014-10-11', 59])
		             ->addRow(['2014-10-12', 65])
		             ->addRow(['2014-10-13', 66])
		             ->addRow(['2014-10-14', 75])
		             ->addRow(['2014-10-15', 76])
		             ->addRow(['2014-10-16', 71])
		             ->addRow(['2014-10-17', 72])
		             ->addRow(['2014-10-18', 63]);*/

		$out= Lava::LineChart('Temps', $voltages, [
		    'title' => 'Weather in October',
		]);
		
		return view ('chartView',['Temps'=>$out, 'session'=>$session]);





	}

	public function getForecast(Request $request,Session $session)
	{
		
		$city = 'Lahore';//$request->input('city');
		if ($request->input('city')) {
			$city = $request->input('city');
		}

		$client = Client::whereEmail($session->get('email'))->first();
		$key = $client->mac_address;
		
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

	public function chart(Session $session)
	{
		//$lava = new Lavacharts; // See note below for Laravel

		$temperatures = Lava::DataTable();

		$temperatures->addDateColumn('Date')
		             ->addNumberColumn('Max Temp')
		             ->addNumberColumn('Mean Temp')
		             ->addNumberColumn('Min Temp')
		             ->addRow(['2014-10-1',  67, 65, 62])
		             ->addRow(['2014-10-2',  68, 65, 61])
		             ->addRow(['2014-10-3',  68, 62, 55])
		             ->addRow(['2014-10-4',  72, 62, 52])
		             ->addRow(['2014-10-5',  61, 54, 47])
		             ->addRow(['2014-10-6',  70, 58, 45])
		             ->addRow(['2014-10-7',  74, 70, 65])
		             ->addRow(['2014-10-8',  75, 69, 62])
		             ->addRow(['2014-10-9',  69, 63, 56])
		             ->addRow(['2014-10-10', 64, 58, 52])
		             ->addRow(['2014-10-11', 59, 55, 50])
		             ->addRow(['2014-10-12', 65, 56, 46])
		             ->addRow(['2014-10-13', 66, 56, 46])
		             ->addRow(['2014-10-14', 75, 70, 64])
		             ->addRow(['2014-10-15', 76, 72, 68])
		             ->addRow(['2014-10-16', 71, 66, 60])
		             ->addRow(['2014-10-17', 72, 66, 60])
		             ->addRow(['2014-10-18', 63, 62, 62]);

		$out= Lava::LineChart('Temps', $temperatures, [
		    'title' => 'Weather in October',
		]);
		
		return view ('chartView',['Temps'=>$out, 'session'=>$session]);

	}



}
