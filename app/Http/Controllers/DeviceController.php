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
	protected $macAddress;
	protected $client;

	public function __construct(Session $session)
	{
		$client = Client::whereEmail($session->get('email'))->first();
		$macAddress = MacAddress::whereUserId($client->id)->get();

		$this->client = $client;
		$this->macAddress = $macAddress;
	}

	public function addDevice(Session $session)
	{

		$session->set('info' , 'Please chose unique name and valid mac address.');

		return view('device',['session'=>$session,'macAddress'=>$this->macAddress]);
	}

	public function removeDevice(Session $session)
	{
		return view('removedevice',['session'=>$session,'macAddress'=>$this->macAddress]);
	}

	public function deleteDevice(Session $session)
	{
		$find_device = Input::get('device');

		if ($find_device == 'nodevice') {
			$session->set('info' , 'Please select device.');
			return view('removedevice',['session'=>$session,'macAddress'=>$this->macAddress]);
		}

		$mac_address = MacAddress::where('device_name',$find_device)
									->where('user_id',$this->client->id)
									->first();

		MacAddress::where('mac_address',$mac_address->mac_address)
					->where('user_id',$this->client->id)
					->update(['mac_address'=> $mac_address->mac_address.'-del',
						      'user_id'=> $mac_address->user_id.'-del']);

		Voltage::where('mac_address',$mac_address->mac_address)
					->where('user_id',$this->client->id)
					->update(['mac_address'=> $mac_address->mac_address.'-del',
						      'user_id'=> $mac_address->user_id.'-del']);

		Current::where('mac_address',$mac_address->mac_address)
					->where('user_id',$this->client->id)
					->update(['mac_address'=> $mac_address->mac_address.'-del',
						      'user_id'=> $mac_address->user_id.'-del']);

		Power::where('mac_address',$mac_address->mac_address)
					->where('user_id',$this->client->id)
					->update(['mac_address'=> $mac_address->mac_address.'-del',
						      'user_id'=> $mac_address->user_id.'-del']);

		$user = $session->get('email');

		\Mail::raw("Following device has been removed from your profile:

			Device details:
			MAC: ".$mac_address->mac_address."
			Device Name: ".$find_device."

			.
			Best Regards
			Happy Energy Saving!!", function ($message) use ($user){
            $message->to($user, 'Beloved User')
        		    ->subject('APPLICATION!');
        });

		$session->set('info' , $find_device.' is removed from your profie.');

		return redirect()->route('data');
	}

	public function turnDevice(Session $session)
	{

		return view('turndevice',['session'=>$session,'macAddress'=>$this->macAddress]);
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

		$session->set('info',$find_device.' is turned '.$status.'.');

		return redirect()->route('data');
	}


}