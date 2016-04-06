<?php
namespace App\Http\Controllers;

use Symfony\Component\HttpFoundation\Session\Session;
use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\MacAddress;

Class DashBoardController extends Controller
{
	public function getnewdashBoard(Session $session)
	{
		$client = Client::whereEmail($session->get('email'))->first();
		$devices = MacAddress::whereUserId($client->id)->count();
		if($devices == 0)
		{
			$session->set('info' , 'Please Add WiFi Device First');
			return view('device',['session'=>$session, 'macAddress'=>null]);
		}
		
		return redirect()->route('data'); // redirect to show CHARTS CLientDataController
	}

	public function postnewdashBoard(Request $request,Session $session)
	{	
		$this->validate($request, [
			'mac_address' => 'required',
			'device_name' => 'required',
		]);

		$client = Client::whereEmail($session->get('email'))->first();
		
		MacAddress::create([
			'user_id'=> $client->id,
			'mac_address'=>$request->input('mac_address'),
			'device_name'=>$request->input('device_name'),
		]);

        $user = $session->get('email');
		$mac = base64_encode($request->input('mac_address'));
		//dd("http://111.68.98.142:149/wifiShield/".$client->api_key.'-'.$mac);

		\Mail::raw("Use following URL to send Post HTTP request:

			For Device: 
			MAC: ".$request->input('mac_address')."
			Device Name: ".$request->input('device_name')."

			http://111.68.98.142:149/wifiShield/".$client->api_key.'-'.$mac."/voltage/000
			http://111.68.98.142:149/wifiShield/".$client->api_key.'-'.$mac."/power/000
			http://111.68.98.142:149/wifiShield/".$client->api_key.'-'.$mac."/current/000

			000 is value(Volts, Amps, Watts) you want to store.

			Best Regards
			Happy Coding!!", function ($message) use ($user){
            $message->to($user, 'Beloved User')
        		    ->subject('APPLICATION!');
        });
        
        $session->set('info' , 'Check email for HTTP Request Method.');
		return redirect()->route('newdashBoard');
	}


}
