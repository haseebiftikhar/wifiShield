<?php
namespace App\Http\Controllers;

//use Symfony\Component\HttpFoundation\Session\Session;
//use Illuminate\Http\Request;

use App\Models\Voltage;
use App\Models\Current;
use App\Models\Power;
use App\Models\MacAddress;
//use Auth;

//use Carbon\Carbon;

// /HSB:346:1527/voltage/100

Class ClientDataController extends Controller
{
	public function storeVoltage($mac_address,$value)
	{	
		
		$date = new \DateTime();
		$timeStemp = $date->getTimestamp();

/*		$date->setTimestamp($time);
		var_dump($date->format('Y-m-d H:i:s'));
*/		
		$user = MacAddress::whereMacAddress($mac_address)->first();
		if (!$user) {
			var_dump('INVALID mac_address');
			exit();
		}

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

	public function storeCurrent($mac_address,$value)
	{
		$date = new \DateTime();
		$timeStemp = $date->getTimestamp();

		$user = MacAddress::whereMacAddress($mac_address)->first();

		if (!$user) {
			var_dump('INVALID mac_address');
			exit();
		}

		Current::create([
			'user_id'=> $user->id,
			'mac_address'=> $mac_address,
			'voltage'=>$value,
			'current'=>$value
,			'date'=>$timeStemp,
		]);
	}

	public function storePower($mac_address,$value)
	{
		$date = new \DateTime();
		$timeStemp = $date->getTimestamp();

		$user = MacAddress::whereMacAddress($mac_address)->first();

		if (!$user) {
			var_dump('INVALID mac_address');
			exit();
		}

		Power::create([
			'user_id'=> $user->id,
			'mac_address'=> $mac_address,
			'voltage'=>$value,
			'power'=>$value,
			'date'=>$timeStemp,
		]);
	}
}