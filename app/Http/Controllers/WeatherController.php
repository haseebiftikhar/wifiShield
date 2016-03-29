<?php
namespace App\Http\Controllers;

use Cmfcmf\OpenWeatherMap;
// use Cmfcmf\OpenWeatherMap\Exception as OWMException;

/**
* Weather API
*/
class WeatherController extends controller
{
	/*
	function __construct(argument)
	{
		# code...
	}*/

	public function getWeather()
	{
		// Language of data (try your own language here!):
		$lang = 'en';

		// Units (can be 'metric' or 'imperial' [default]):
		$units = 'metric';

		// Create OpenWeatherMap object. 
		// Don't use caching (take a look into Examples/Cache.php to see how it works).
		$owm = new OpenWeatherMap('233dbc9c54dbc84eebcaefb852319715');

		try {
		    $weather = $owm->getWeather('Gilgit', $units, $lang);
		} catch(OWMException $e) {
		    echo 'OpenWeatherMap exception: ' . $e->getMessage() . ' (Code ' . $e->getCode() . ').';
		} catch(\Exception $e) {
		    echo 'General exception: ' . $e->getMessage() . ' (Code ' . $e->getCode() . ').';
		}

		echo $weather->temperature;
		//echo $weather->city;
		// echo $weather->lon;
		// echo $weather->lat;
		// echo $weather->country;
		// echo $weather->name;
		var_dump($weather->city->name);
		var_dump($weather->city->country);
		//var_dump($weather->city);
	}

	public function weatherForecast($city)
	{
		$lang = 'en';
		// Units (can be 'metric' or 'imperial' [default]):
		$units = 'metric';
		// Get OpenWeatherMap object. Don't use caching (take a look into Example_Cache.php to see how it works).
		$owm = new OpenWeatherMap('233dbc9c54dbc84eebcaefb852319715');
		// Example 1: Get forecast for the next 10 days for Berlin.
		$forecast = $owm->getWeatherForecast($city, $units, $lang, '', 10);
		echo "Weather Forecast<hr />\n\n\n";
		echo "City: " . $forecast->city->name;
		echo "<br />\n";
		echo "LastUpdate: " . $forecast->lastUpdate->format('d.m.Y H:i');
		echo "<br />\n";
		echo "Sunrise : " . $forecast->sun->rise->format("H:i:s") . " Sunset : " . $forecast->sun->set->format("H:i:s");
		echo "<br />\n";
		echo "<br />\n";
		foreach ($forecast as $weather) {
		    // Each $weather contains a Cmfcmf\ForecastWeather object which is almost the same as the Cmfcmf\Weather object.
		    // Take a look into 'Examples_Current.php' to see the available options.
		    echo "Weather forecast at " . $weather->time->day->format('d.m.Y') . " from " . $weather->time->from->format('H:i') . " to " . $weather->time->to->format('H:i');
		    echo "<br />\n";
		    echo $weather->temperature;
		    echo "<br />\n";
		    echo "---";
		    echo "<br />\n";
		}
		// Example 2: Get forecast for the next 3 days for Berlin.
		/*$forecast = $owm->getWeatherForecast('Berlin', $units, $lang, '', 3);
		echo "EXAMPLE 2<hr />\n\n\n";
		foreach ($forecast as $weather) {
		    echo "Weather forecast at " . $weather->time->day->format('d.m.Y') . " from " . $weather->time->from->format('H:i') . " to " . $weather->time->to->format('H:i') . "<br />";
		    echo $weather->temperature . "<br />\n";
		    echo "---<br />\n";
			}*/
	}
}