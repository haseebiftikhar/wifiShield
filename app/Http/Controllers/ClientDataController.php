<?php
namespace App\Http\Controllers;

use Symfony\Component\HttpFoundation\Session\Session;
use Illuminate\Http\Request;

use App\Models\Client;
use App\Models\Voltage;
// use App\Models\Current;
// use App\Models\Power;
//use App\Models\MacAddress;


Class ClientDataController extends Controller
{
	public function showVoltage (Session $session)
	{
		$session->set('email' , 'haseeb@brokergenius.com');

		$client = Client::whereEmail($session->get('email'))->first();

		$voltages = \DB::table('voltages')->where('user_id', $client->id)->lists('voltage');

		foreach ($voltages as $voltage) {
			var_dump($voltage);
		}
	}



}
