<?php
namespace App\Http\Controllers;

use Symfony\Component\HttpFoundation\Session\Session;
use App\Models\Client;
use App\Models\MacAddress;


class HomeController extends Controller
{
	
	function index(Session $session)
	{
		$client = Client::whereEmail($session->get('email'))->first();

		$macAddress = MacAddress::whereUserId($client->id)->get();
		
		$view = view ('home',['session'=>$session, 'macAddress'=>$macAddress]);
		
	    return	$view;
	}
}