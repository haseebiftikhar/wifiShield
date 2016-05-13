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
	protected $guzzle;
	protected $date;



	public function __construct(Response $response, \GuzzleHttp\Client $guzzle)
	{
		$this->response = $response;
		$this->guzzle = $guzzle;
		$timezone = new \DateTimeZone('Asia/Karachi');
		$date = new \DateTime();
		$date->setTimezone($timezone);
		$this->date = $date;
	}

	public function deviceControl($api_key,Request $request)
	{
		$mac_address = base64_decode($api_key);
		/* to get mac address from headers 
		 * $mac_address = $request->header('mac-address');
		 */

		if(!$mac_address)
		{
			$val_resp = 'Mac address not found';
			return $this->response->bad_request($val_resp);
		}

		//Authenticate Mac 
		$user = MacAddress::whereMacAddress($mac_address)->first();
		if (!$user) {
			return $this->response->unauthorize();
		}

		if ($user->status == 1) {
			return $this->response->keep_on();
		}
		if ($user->status == 0) {
			return $this->response->turn_off();
		}

	}

	public function storeVoltage($api_key,$value,Request $request)
	{	
		$mac_address = base64_decode($api_key);

		if(!$mac_address)
		{
			$val_resp = 'Mac address not found';
			return $this->response->bad_request($val_resp);
		}

		//Authenticate Mac !!
		$user = MacAddress::whereMacAddress($mac_address)->first();
		if (!$user) {
			return $this->response->unauthorize();
		}


		$timeStemp = $this->date->getTimestamp();
		$data = [
			'user_id'=> $user->user_id,
			'mac_address'=> $mac_address,
			'voltage'=>$value,
			'date'=>$this->date->format('c'),
		];
		$url = 'http://localhost:9200/wifishield/voltage/';

		$request = $this->guzzle->post($url, ['json' => $data]);

		//Store voltages in Data Base
		Voltage::create([
			'user_id'=> $user->user_id,
			'mac_address'=> $mac_address,
			'voltage'=>$value,
			'date'=>$timeStemp,
			'only_date'=>$this->date,
		]);


		$response = 'value saved';
		return $this->response->success($response);

	}

	public function storeCurrent($api_key,$value,Request $request)
	{	
        $mac_address = base64_decode($api_key);

		if(!$mac_address)
		{
			$val_resp = 'Mac address not found';
			return $this->response->bad_request($val_resp);
		}

		//Authenticate Mac !!
		$user = MacAddress::whereMacAddress($mac_address)->first();
		if (!$user) {
			return $this->response->unauthorize();
		}


		$timeStemp = $this->date->getTimestamp();

		$data = [
			'user_id'=> $user->user_id,
			'mac_address'=> $mac_address,
			'current'=>$value,
			'date'=>$this->date->format('c'),
		];

		$url = 'http://localhost:9200/wifishield/current/';

		$request = $this->guzzle->post($url, ['json' => $data]);

		//Store voltages in Data Base
		Current::create([
			'user_id'=> $user->user_id,
			'mac_address'=> $mac_address,
			'current'=>$value,
			'date'=>$timeStemp,
			'only_date'=>$this->date,
		]);
		$response = 'value saved';
		return $this->response->success($response);

	}

	public function storePower($api_key,$value,Request $request)
	{	

		$mac_address = base64_decode($api_key);

		if(!$mac_address)
		{
			$val_resp = 'Mac address not found';
			return $this->response->bad_request($val_resp);
		}

		//Authenticate Mac !!
		$user = MacAddress::whereMacAddress($mac_address)->first();
		if (!$user) {
			return $this->response->unauthorize();
		}


		$timeStemp = $this->date->getTimestamp();

		$data = [
			'user_id'=> $user->user_id,
			'mac_address'=> $mac_address,
			'power'=>$value,
			'date'=>$this->date->format('c'),
		];

		$url = 'http://localhost:9200/wifishield/power/';

		$request = $this->guzzle->post($url, ['json' => $data]);

		//Store Power
		Power::create([
			'user_id'=> $user->user_id,
			'mac_address'=> $mac_address,
			'power'=>$value,
			'date'=>$timeStemp,
			'only_date'=>$this->date,
		]);

		$response = 'value saved';
		return $this->response->success($response);
	}
}