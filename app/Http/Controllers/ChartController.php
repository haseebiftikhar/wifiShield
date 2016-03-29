<?php
namespace App\Http\Controllers;

use Khill\Lavacharts\Lavacharts;
use Khill\Lavacharts\Laravel\LavachartsFacade as Lava; //remove this and use BACKSLESH "\Lava" in code

class ChartController extends Controller
{
	public function getChart()
	{
		//$lava = new Lavacharts; // See note below for Laravel

		$reasons = Lava::DataTable();

		$reasons->addStringColumn('Reasons')
		        ->addNumberColumn('Percent')
		        ->addRow(['Check Reviews', 50])
		        ->addRow(['Watch Trailers', 20])
		        ->addRow(['See Actors Other Work', 4])
		        ->addRow(['Settle Argument', 89]);

		$out= Lava::ColumnChart('IMDB', $reasons, [
		    'title' => 'Reasons I visit IMDB'
		]);

		return view ('welcome',['IMDB'=>$out]);
	}
}
