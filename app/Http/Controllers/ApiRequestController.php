<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\Voltage;
use App\Models\Current;
use App\Models\Power;
use App\Models\MacAddress;

//use Carbon\Carbon;

Class ApiRequestController extends Controller
{
	public function storeVoltage($api_key,$value,Request $request)
	{	

		//MAC Address from headers !! 
		$mac_address = $request->header('mac-address');
//		$mac_address = 'anc12345'; // temperory 
		if(!$mac_address)
		{
			var_dump('Invalid MAC');
			exit();
		}

		//Authenticate user
		$user = Client::whereApiKey($api_key)->first();
		if (!$user) {
			var_dump('INVALID api key');
			exit();
		}

		//Set time
		$date = new \DateTime();
		$timeStemp = $date->getTimestamp();
/*		$date->setTimestamp($time);
		var_dump($date->format('Y-m-d H:i:s'));
*/

		//Store voltages in Data Base
		Voltage::create([
			'user_id'=> $user->id,
			'mac_address'=> $mac_address,
			'voltage'=>$value,
			'date'=>$timeStemp,
		]);

		 //Log file
        $path = 'C:\wamp\www\wifiShield\Logs';
        $this->myfile = fopen($path . "\_voltage" . date('Y-m-d-H-m-s') . '.txt', "a") or die("Unable to open file!");

		/*

		Voltage::
		var_dump($user->id);
		var_dump($value);*/
/*		$carbon = Carbon::now();
		$date= $carbon->toDateTimeString();
		var_dump($date);
		$dt = Carbon::parse($date);
		var_dump($dt->timestamp);
		exit();
		$daysSinceEpoch = Carbon::createFromTimestamp(0)->diffInDays();
		var_dump($daysSinceEpoch);
*/
	}

	public function storeCurrent($api_key,$value,Request $request)
	{	

		//MAC Address from headers !! 
		$mac_address = $request->header('mac-address');
//		$mac_address = 'anc12345'; // temperory 
		if(!$mac_address)
		{
			var_dump('Invalid MAC');
			exit();
		}

		//Authenticate user
		$user = Client::whereApiKey($api_key)->first();
		if (!$user) {
			var_dump('INVALID api key');
			exit();
		}

		//Set time
		$date = new \DateTime();
		$timeStemp = $date->getTimestamp();

		//Store voltages in Data Base
		Current::create([
			'user_id'=> $user->id,
			'mac_address'=> $mac_address,
			'current'=>$value,
			'date'=>$timeStemp,
		]);

	}

	public function storePower($api_key,$value,Request $request)
	{	

		//MAC Address from headers !! 
		$mac_address = $request->header('mac-address');
//		$mac_address = 'anc12345'; // temperory 
		if(!$mac_address)
		{
			var_dump('Invalid MAC');
			exit();
		}

		//Authenticate user
		$user = Client::whereApiKey($api_key)->first();
		if (!$user) {
			var_dump('INVALID api key');
			exit();
		}

		//Set time
		$date = new \DateTime();
		$timeStemp = $date->getTimestamp();

		//Store Power
		Power::create([
			'user_id'=> $user->id,
			'mac_address'=> $mac_address,
			'voltage'=>$value,
			'power'=>$value,
			'date'=>$timeStemp,
		]);
	}
}