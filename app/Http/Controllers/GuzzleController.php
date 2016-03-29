<?php
namespace App\Http\Controllers;

//use Symfony\Component\HttpFoundation\Session\Session;
//use Illuminate\Http\Request;
//use Illuminate\Support\ServiceProvider;
//use Khill\Lavacharts\Laravel\LavachartsFacade as Lava;
//use Khill\Lavacharts\Lavacharts;

/**
* 
*/
class GuzzleController extends Controller
{
	//private $guzzle;

	/*public function __construct(GuzzleHttp\Client $guzzle)
	{
		$this->guzzle = $guzzle;
	}*/
	
	public function get_git(\GuzzleHttp\Client $guzzle)
	{
		/*$guzzle = new \GuzzleHttp\Client();
	    //dd($guzzle);
	    $response = $guzzle->get('https://api.github.com/users/haseebiftikhar');
	    return $response->getBody();
    */

      $response = $guzzle->get("https://api.github.com/users/haseebiftikhar");
      return $response->getBody();
      //return $response->json();
	}

/*======== NOT Working Code ===========*/
/*	public function dataTable()
	{
		$stocksTable = \Lava::DataTable();  // Lava::DataTable() if using Laravel

    	$stocksTable->addDateColumn('Day of Month')
        	        ->addNumberColumn('Projected')
            	    ->addNumberColumn('Official');

    	// Random Data For Example
    	for ($a = 1; $a < 30; $a++)
    	{
        	$rowData = [
          		"2014-8-$a", rand(800,1000), rand(800,1000)
        	];

        	$stocksTable->addRow($rowData);
    	}

    	$stocksTable->addColumns([
    		['date', 'Day of Month'],
    		['number', 'Projected'],
  		  	['number', 'Official']
  		]);

  		\Lava::LineChart('Stocks', $stocksTable, ['title' => 'Stock Market Trends']);

  		echo \Lava::render('LineChart', 'Stocks', 'stocks-div');

    }*/


}