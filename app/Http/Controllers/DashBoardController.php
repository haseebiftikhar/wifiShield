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
		
		return redirect()->route('data'); 
	}

	public function postnewdashBoard(Request $request,Session $session)
	{	
		$this->validate($request, [
			'mac_address' => 'required|unique:macaddreses|max:255',
			'device_name' => 'required|max:255',
		]);
		$client = Client::whereEmail($session->get('email'))->first();
		
		MacAddress::create([
			'user_id'=> $client->id,
			'mac_address'=>$request->input('mac_address'),
			'device_name'=>$request->input('device_name'),
			'status'=>1,
		]);

        $user = $session->get('email');
		

		\Mail::raw("Following device has been added to your profile:

			Device details:

			MAC: ".$request->input('mac_address')."
			Device Name: ".$request->input('device_name')."


			Best Regards
			Happy Energy Saving!!", function ($message) use ($user){
            $message->to($user, 'Beloved User')
        		    ->subject('APPLICATION!');
        });
        
        $session->set('info' , $request->input('device_name').' is added to your profie.');
		return redirect()->route('newdashBoard');
	}


}
