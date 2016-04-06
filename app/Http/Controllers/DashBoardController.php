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
		return redirect()->route('newdashBoard');
	}


}
