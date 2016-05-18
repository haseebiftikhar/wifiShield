<?php
namespace App\Http\Controllers;

use Symfony\Component\HttpFoundation\Session\Session;
use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\MacAddress;

use App\Data\Chart;
use App\Data\DataProfile;
use Illuminate\Support\Facades\Input;

Class ClientDataController extends Controller
{
	protected $chart;
	protected $dataProfile;
	protected $date;

	function __construct(Chart $chart, DataProfile $dataProfile)
	{
		$this->chart = $chart;
		$this->dataProfile = $dataProfile;

		$timezone = new \DateTimeZone('Asia/Karachi');
		$date = new \DateTime();
		$date->setTimezone($timezone);
		$this->date=$date;
	}

	public function dailyVoltage($id)
	{
		$tempValue = $this->dataProfile->dailyVoltageData($id,
														  $this->date->format('Y-m-d'));
		return $tempValue;
	}

	public function dailyCurrent($id)
	{
		$tempValue = $this->dataProfile->dailyCurrentData($id,
														  $this->date->format('Y-m-d'));
		return $tempValue;
	}

	public function dailyPower($id)
	{
		$tempValue = $this->dataProfile->dailyPowerData($id,
														  $this->date->format('Y-m-d'));
		return $tempValue;
	}	



	public function myData(Session $session,Request $request)
	{
		$count = 0;

		$getVoltage = $request->input('voltage');
		$getCurrent = $request->input('current');
		$getPower = $request->input('power');

		if ($getVoltage == 'voltage') {
			$count = $count + 1;
		}
		if ($getCurrent == 'current') {
			$count = $count + 1;
		}
		if ($getPower == 'power') {
			$count = $count + 1;
		}

		$client = Client::whereEmail($session->get('email'))->first();
		if($client == null){
			$session->set('info' , 'Please Signin.'); 
			return redirect()->route('auth.signin');
		}
		$macAddress = MacAddress::whereUserId($client->id)->get();
		
		$timezone = new \DateTimeZone('Asia/Karachi');

		$currentDate = new \DateTime();
		$currentDate->setTimezone($timezone);

		$pastDate = new \DateTime();
		$pastDate->setTimezone($timezone);
		$pastDate->modify('-14 days');


		$voltage=$this->dataProfile->dataById('voltage',
											$client->id, 
											$pastDate->format('Y-m-d'), 
											$currentDate->format('Y-m-d'));
		$current=$this->dataProfile->dataById('current',
											$client->id, 
											$pastDate->format('Y-m-d'), 
											$currentDate->format('Y-m-d'));
		$power=$this->dataProfile->dataById('power',
											$client->id, 
											$pastDate->format('Y-m-d'), 
											$currentDate->format('Y-m-d'));

		$out = $this->chart->getLineChart($voltage,$current,$power,$value = null);

		

		$data = ['voltage'=>$dailyVoltage = self::dailyVoltage($client->id),
				 'current'=>$dailyCurrent = self::dailyCurrent($client->id),
				 'power'=>$dailyPower = self::dailyPower($client->id)
				];
		

		return view('dashboard',['Temps'=>$out,'data'=>$data,'macAddress'=>$macAddress,'session'=>$session]);
	}




	public function showData(Session $session)
	{
		$client = Client::whereEmail($session->get('email'))->first();
		if($client == null){
			$session->set('info' , 'Please Signin.'); 
			return redirect()->route('auth.signin');
		}
		$macAddress = MacAddress::whereUserId($client->id)->get();
		
		$timezone = new \DateTimeZone('Asia/Karachi');

		$currentDate = new \DateTime();
		$currentDate->setTimezone($timezone);

		$pastDate = new \DateTime();
		$pastDate->setTimezone($timezone);
		$pastDate->modify('-14 days');


		$voltage=$this->dataProfile->dataById('voltage',
											$client->id, 
											$pastDate->format('Y-m-d'), 
											$currentDate->format('Y-m-d'));
		$current=$this->dataProfile->dataById('current',
											$client->id, 
											$pastDate->format('Y-m-d'), 
											$currentDate->format('Y-m-d'));
		$power=$this->dataProfile->dataById('power',
											$client->id, 
											$pastDate->format('Y-m-d'), 
											$currentDate->format('Y-m-d'));

		$out = $this->chart->getLineChart($voltage,$current,$power,$value = null);

		

		$data = ['voltage'=>$dailyVoltage = self::dailyVoltage($client->id),
				 'current'=>$dailyCurrent = self::dailyCurrent($client->id),
				 'power'=>$dailyPower = self::dailyPower($client->id)
				];
		

		return view('dashboard',['Temps'=>$out,'data'=>$data,'macAddress'=>$macAddress,'session'=>$session]);
	}

	public function showSelectedData($value, Session $session)
	{
		$client = Client::whereEmail($session->get('email'))->first();
		$macAddress = MacAddress::whereUserId($client->id)->get();

		$mac_address = MacAddress::whereDeviceName($value)->first();

		$timezone = new \DateTimeZone('Asia/Karachi');

		$currentDate = new \DateTime();
		$currentDate->setTimezone($timezone);

		$pastDate = new \DateTime();
		$pastDate->setTimezone($timezone);
		$pastDate->modify('-14 days');


		$voltage=$this->dataProfile->dataByMac('voltage',
										$mac_address->mac_address, 
										$pastDate->format('Y-m-d'), 
										$currentDate->format('Y-m-d'));
		$current=$this->dataProfile->dataByMac('current',
										$mac_address->mac_address, 
										$pastDate->format('Y-m-d'), 
										$currentDate->format('Y-m-d'));
		$power=$this->dataProfile->dataByMac('power',
										$mac_address->mac_address, 
										$pastDate->format('Y-m-d'), 
										$currentDate->format('Y-m-d'));

		$out = $this->chart->getLineChart($voltage,$current,$power,$value);

		$data = ['voltage'=>$dailyVoltage = self::dailyVoltage($client->id),
				 'current'=>$dailyCurrent = self::dailyCurrent($client->id),
				 'power'=>$dailyPower = self::dailyPower($client->id)
				];
		

		return view('dashboard',['Temps'=>$out,'data'=>$data,'macAddress'=>$macAddress,'session'=>$session]);
	}

	public function searchData(Request $request, Session $session)
	{

		$from_date = $request->input('from_date');
		$to_date = $request->input('to_date');
		$find_device = Input::get('device');
		
		if($from_date == null)
		{
			$session->set('info' , 'Please Add Date'); 
			return redirect()->route('data');
		}
		if($to_date == null)
		{
			$session->set('info' , 'Please Add Date'); 
			return redirect()->route('data');
		}
		if($find_device == 'nodevice')
		{
			$session->set('info' , 'Please Select Device'); 
			return redirect()->route('data');
		}

		$client = Client::whereEmail($session->get('email'))->first();

		$macAddress = MacAddress::whereUserId($client->id)->get();

		$mac_address = MacAddress::whereDeviceName($find_device)->first();


		$voltage=$this->dataProfile->dataByMac('voltage',
										$mac_address->mac_address, 
										$from_date, 
										$to_date);
		$current=$this->dataProfile->dataByMac('current',
										$mac_address->mac_address, 
										$from_date, 
										$to_date);
		$power=$this->dataProfile->dataByMac('power',
										$mac_address->mac_address, 
										$from_date, 
										$to_date);

		$out = $this->chart->getLineChart($voltage,$current,$power,$find_device);
		
		$data = ['voltage'=>$dailyVoltage = self::dailyVoltage($client->id),
				 'current'=>$dailyCurrent = self::dailyCurrent($client->id),
				 'power'=>$dailyPower = self::dailyPower($client->id)
				];
		

		return view('dashboard',['Temps'=>$out,'data'=>$data,'macAddress'=>$macAddress,'session'=>$session]);

	}

	public function dailyUsageChart(Request $request, Session $session)
	{

		$client = Client::whereEmail($session->get('email'))->first();

		$macAddress = MacAddress::whereUserId($client->id)->get();

		$out2 = $this->chart->gaugeChart();

		return view('dashboard',['Gauge'=>$out2,'macAddress'=>$macAddress,'session'=>$session]);
	}


}
