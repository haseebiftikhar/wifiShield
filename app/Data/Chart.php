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

}