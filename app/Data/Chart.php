<?php
namespace App\Data;

use Khill\Lavacharts\Lavacharts;
use Khill\Lavacharts\Laravel\LavachartsFacade as Lava;


class Chart
{
	public function getLineChart( $voltage,$current,$power,$name)
	{
		if($name == null){
			$title = 'Overall Consumption';
		}
		else{
			$title = 'Consumption for '.$name;
		}

		$count = count($power['power']);

		$variable = Lava::DataTable();

		$variable->addDateColumn('Date')
		         ->addNumberColumn('Avg Voltage')
		         ->addNumberColumn('Avg Current')
		         ->addNumberColumn('Avg Power');
		         for ($i=0; $i < $count; $i++) { 

		         	if ($voltage['voltage'][$i] == null) {
		         		$voltage['voltage'][$i] = 0;
		         	}
		         	if ($current['current'][$i] == null) {
		         		$current['current'][$i] = 0;
		         	}
		         	if ($power['power'][$i] == null) {
		         		$power['power'][$i] = 0;
		         	}

		         	$variable->addRow([$voltage['date'][$i],  
		         		$voltage['voltage'][$i], 
		         		$current['current'][$i], 
		         		$power['power'][$i]]);
		         }

		$out = Lava::LineChart('Temps', $variable, [
		    'title'=> $title,
		    'backgroundColor'   => '#F2F2F2',
		    'width' => 1200,
		    'height' => 600,
		    'pointSize' => 5,
		    'pointShape'=> "square",
		    'lineWidth'=> 3,
		    'vAxis'=>['scaleType'=>'Continuous'],
		    'hAxis'=>['gridlines'=>['count'=>$count]]
		    
		]);

		return $out;

	}

	public function gaugeChart($voltage,$power,$current)
	{
		if($voltage == null){
			$voltage = 0;
		}
		if($power == null){
			$power = 0;
		}
		if($current == null){
			$current = 0;
		}
		$temps = Lava::DataTable();

		$temps->addStringColumn('Type')
		      ->addNumberColumn('Value')
		      ->addRow(['Voltage', $voltage])
		      ->addRow(['Power', $power])
		      ->addRow(['Current', $current]);

		$out = Lava::GaugeChart('Gauge', $temps, [
		    'width'      => 150,
		    'greenFrom'  => 0,
		    'greenTo'    => 69,
		    'yellowFrom' => 70,
		    'yellowTo'   => 89,
		    'redFrom'    => 90,
		    'redTo'      => 100,
		    'majorTicks' => [
		        'Safe',
		        'Critical'
		    ]
		]);
		return $out;
	}

}