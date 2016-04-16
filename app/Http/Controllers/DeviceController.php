<?php
namespace App\Http\Controllers;

use Symfony\Component\HttpFoundation\Session\Session;
use Illuminate\Support\Facades\Input;
use App\Models\Client;
use App\Models\MacAddress;
use App\Models\Voltage;
use App\Models\Current;
use App\Models\Power;


Class DeviceController  extends Controller
{
	public function addDevice(Session $session)
	{
		$client = Client::whereEmail($session->get('email'))->first();

		$macAddress = MacAddress::whereUserId($client->id)->get();

		$session->set('info' , 'Please chose unique name and valid mac address.');

		return view('device',['session'=>$session,'macAddress'=>$macAddress]);
	}

	public function removeDevice(Session $session)
	{

		$client = Client::whereEmail($session->get('email'))->first();

		$macAddress = MacAddress::whereUserId($client->id)->get();
		return view('removedevice',['session'=>$session,'macAddress'=>$macAddress]);
	}

	public function deleteDevice(Session $session)
	{
		$client = Client::whereEmail($session->get('email'))->first();
		$find_device = Input::get('device');

		$mac_address = MacAddress::where('device_name',$find_device)
									->where('user_id',$client->id)
									->first();

		MacAddress::where('mac_address',$mac_address->mac_address)
					->where('user_id',$client->id)
					->update(['mac_address'=> $mac_address->mac_address.'-del',
						      'user_id'=> $mac_address->user_id.'-del']);

		Voltage::where('mac_address',$mac_address->mac_address)
					->where('user_id',$client->id)
					->update(['mac_address'=> $mac_address->mac_address.'-del',
						      'user_id'=> $mac_address->user_id.'-del']);

		Current::where('mac_address',$mac_address->mac_address)
					->where('user_id',$client->id)
					->update(['mac_address'=> $mac_address->mac_address.'-del',
						      'user_id'=> $mac_address->user_id.'-del']);

		Power::where('mac_address',$mac_address->mac_address)
					->where('user_id',$client->id)
					->update(['mac_address'=> $mac_address->mac_address.'-del',
						      'user_id'=> $mac_address->user_id.'-del']);

		return redirect()->route('data');
	}

	public function turnDevice(Session $session)
	{
		$client = Client::whereEmail($session->get('email'))->first();
		$macAddress = MacAddress::whereUserId($client->id)->get();

		return view('turndevice',['session'=>$session,'macAddress'=>$macAddress]);
	}

	public function changeStatus(Session $session)
	{
		$find_device = Input::get('tdevice');
		$status = Input::get('status');
		
		if($find_device == 'nodevice')
		{
			$session->set('info' , 'Please Select Device'); 
			return redirect()->route('turn.device');
		}

		$client = Client::whereEmail($session->get('email'))->first();
		$mac_address = MacAddress::where('device_name',$find_device)
									->where('user_id',$client->id)
									->first();

		if ($status == 'ON') {
			MacAddress::where('mac_address',$mac_address->mac_address)
					->where('user_id',$client->id)
					->update(['status'=> 1]);
		}

		if ($status == 'OFF') {
			MacAddress::where('mac_address',$mac_address->mac_address)
					->where('user_id',$client->id)
					->update(['status'=> 0]);
		}

		return redirect()->route('data');
	}


}