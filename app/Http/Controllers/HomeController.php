<?php
namespace App\Http\Controllers;

use Symfony\Component\HttpFoundation\Session\Session;
use App\Models\Client;
use App\Models\MacAddress;


class HomeController extends Controller
{
	
	function index(Session $session)
	{
		if ($session->get('email') == null)
		{
			return redirect()->route('login');
		}
		$client = Client::whereEmail($session->get('email'))->first();
		$macAddress = MacAddress::whereUserId($client->id)->get();
		
		$view = view ('home',['session'=>$session, 'macAddress'=>$macAddress]);
		
	    return	$view;
	}

	function login(Session $session)
	{
		if ($session->get('email') != null)
		{
			return redirect()->route('home');
		}
		$view = view ('login',['session'=>$session, 'macAddress'=>null]);
		
	    return	$view;
	}
}