<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\Voltage;
use App\Models\Current;
use App\Models\Power;
use App\Models\MacAddress;

use App\Response\Response;

//use Carbon\Carbon;

Class ApiRequestController extends Controller
{

	protected $response;

	public function __construct(Response $response)
	{
		$this->response = $response;
	}

	public function storeVoltage($api_key,$value,Request $request)
	{	

		//MAC Address from headers !! 
		$mac_address = $request->header('mac-address');
		if(!$mac_address)
		{
			$val_resp = 'Mac address not found';
			return $this->response->bad_request($val_resp);
		}

		//Authenticate Mac 
		$macAddress = MacAddress::whereMacAddress($mac_address)->first();
		if (!$macAddress) {
			return $this->response->unauthorize();
		}

		//Authenticate user
		$user = Client::whereApiKey($api_key)->first();
		if (!$user) {
			return $this->response->forbidden();
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
		$response = 'value saved';
		return $this->response->success($response);

		 //Log file
        $path = 'C:\wamp\www\wifiShield\Logs';
        $this->myfile = fopen($path . "\_voltage" . date('Y-m-d-H-m-s') . '.txt', "a") or die("Unable to open file!");


	}

	public function storeCurrent($api_key,$value,Request $request)
	{	

		//MAC Address from headers !! 
		$mac_address = $request->header('mac-address');
		if(!$mac_address)
		{
			$val_resp = 'Mac address not found';
			return $this->response->bad_request($val_resp);
		}
		
		//Authenticate Mac 
		$macAddress = MacAddress::whereMacAddress($mac_address)->first();
		if (!$macAddress) {
			return $this->response->unauthorize();
		}

		//Authenticate user
		$user = Client::whereApiKey($api_key)->first();
		if (!$user) {
			return $this->response->forbidden();
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

		$response = 'value saved';
		return $this->response->success($response);

	}

	public function storePower($api_key,$value,Request $request)
	{	

		//MAC Address from headers !! 
		$mac_address = $request->header('mac-address');
		if(!$mac_address)
		{
			$val_resp = 'Mac address not found';
			return $this->response->bad_request($val_resp);
		}
		
		//Authenticate Mac 
		$macAddress = MacAddress::whereMacAddress($mac_address)->first();
		if (!$macAddress) {
			return $this->response->unauthorize();
		}

		//Authenticate user
		$user = Client::whereApiKey($api_key)->first();
		if (!$user) {
			return $this->response->forbidden();
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

		$response = 'value saved';
		return $this->response->success($response);
	}
}