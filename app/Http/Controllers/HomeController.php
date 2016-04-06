<?php
namespace App\Http\Controllers;

use Symfony\Component\HttpFoundation\Session\Session;


class HomeController extends Controller
{
	
	function index(Session $session)
	{
		
		
			$view = view ('home',['session'=>$session, 'macAddress'=>null]);
		
	    	return	$view;
	}
}