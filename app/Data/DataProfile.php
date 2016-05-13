<?php
namespace App\Data;

use DB;
use App\Data\DataProfile;

/**
*  Class Data Profile
*  Author haseeb@brokergenius.com
*/
class DataProfile
{
	protected $date;
	
	function __construct()
	{
		$timezone = new \DateTimeZone('Asia/Karachi');
		$date = new \DateTime();
		$date->setTimezone($timezone);
		$this->date = $date;
	}

	public function dateChange($value)
	{
		$this->date->modify($value);
		return $this->date->getTimestamp();
	}

	public function dataById($find,$user_id,$strDate,$endDate)
	{
		$start= self::dateChange($strDate);
		$end = self::dateChange($endDate);

		$value = array();
		$date = array();

		if ($find == 'voltage') {
			$table = 'voltages';
		}
		if ($find == 'current') {
			$table = 'currents';
		}
		if ($find == 'power') {
			$table = 'powers';
		}

		while ($start <= $end) {
			$tempEnd = $start + 86400;
			$data = \DB::table($table)
                     ->select("*")
                     ->where('user_id', $user_id)
                     ->where('date', ">=", $start)
                     ->where('date', "<=", $tempEnd)
                     ->orderBy('date', 'asc')
                     ->avg($find)
            ;

            $value[$find][] = $data;
            $date['date'][] = date('y-m-d',$start);
            $start = $start + 86400;
		}

		$items = array_merge($value,$date);
        return $items;
	}

	public function dataByMac($find,$mac_address,$strDate,$endDate)
	{
		$start= self::dateChange($strDate);
		$end = self::dateChange($endDate);

		$value = array();
		$date = array();

		if ($find == 'voltage') {
			$table = 'voltages';
		}
		if ($find == 'current') {
			$table = 'currents';
		}
		if ($find == 'power') {
			$table = 'powers';
		}

		while ($start <= $end) {
			$tempEnd = $start + 86400;
			$data = \DB::table($table)
                     ->select("*")
                     ->where('mac_address', $mac_address)
                     ->where('date', ">=", $start)
                     ->where('date', "<=", $tempEnd)
                     ->orderBy('date', 'asc')
                     ->avg($find)
            ;

            $value[$find][] = $data;
            $date['date'][] = date('y-m-d',$start);
            $start = $start + 86400;
		}

		$items = array_merge($value,$date);
        return $items;
	}

	public function dailyVoltageData($user_id,$date)
	{
		$data = \DB::table('voltages')
				->select("*")
				->where("user_id",$user_id)
				->where('only_date', $date)
                ->orderBy('date', 'asc')
                ->avg('voltage')
        ;
        if($data == null){
        	$data = 0;
        }
        return $data;
	}

	public function dailyCurrentData($user_id,$date)
	{
		$data = \DB::table('currents')
				->select("*")
				->where("user_id",$user_id)
				->where('only_date', $date)
                ->orderBy('date', 'asc')
                ->avg('current')
        ;
        if($data == null){
        	$data = 0;
        }
        return $data;
	}

	public function dailyPowerData($user_id,$date)
	{
		$data = \DB::table('powers')
				->select("*")
				->where("user_id",$user_id)
				->where('only_date', $date)
                ->orderBy('date', 'asc')
                ->avg('power')
        ;
        if($data == null){
        	$data = 0;
        }
        return $data;
	}

}
