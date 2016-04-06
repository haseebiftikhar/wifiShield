<?php
namespace App\Http\Controllers;

use Symfony\Component\HttpFoundation\Session\Session;
use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\MacAddress;

Class ClientDataController extends Controller
{
	public function showData(Session $session)
	{
		// var_dump('expression');
		// $session->set('email','haseeb@brokergenius.com');
		$client = Client::whereEmail($session->get('email'))->first();

		$macAddress = MacAddress::whereUserId($client->id)->get();
		
		$mac_address = MacAddress::whereUserId($client->id)->first();
		

		return view('dashboard',['macAddress'=>$macAddress,'mac_address'=>$mac_address,'session'=>$session]);
	}

	public function showSelectedData($value, Session $session)
	{
		// $session->set('email','haseeb@brokergenius.com');
		$client = Client::whereEmail($session->get('email'))->first();
		$macAddress = MacAddress::whereUserId($client->id)->get();

		$mac_address = MacAddress::whereDeviceName($value)->first();
		//var_dump($mac_address->mac_address);



		return view('dashboard',['macAddress'=>$macAddress,'mac_address'=>$mac_address,'session'=>$session]);
	}

	public function searchData(Request $request, Session $session)
	{

		$from_date = $request->input('from_date');
		$to_date = $request->input('to_date');
		$find_device = $request->input('find_device');

		if($from_date == null)
		{
			$session->set('info' , 'Date required'); 
			return redirect()->route('data');
		}
		if($to_date == null)
		{
			$session->set('info' , 'Date required'); 
			return redirect()->route('data');
		}
		if($find_device == null)
		{
			$session->set('info' , 'Device name required'); 
			return redirect()->route('data');
		}
		// $session->set('email','haseeb@brokergenius.com');
		$client = Client::whereEmail($session->get('email'))->first();

		$macAddress = MacAddress::whereUserId($client->id)->get();

		$mac_address = MacAddress::whereDeviceName($find_device)->first();


		return view('dashboardSearch',['macAddress'=>$macAddress,
										'session'=>$session, 
										'mac_address'=>$mac_address,
										'from_date'=>$from_date,
										'to_date'=>$to_date
										]);
	}


}
