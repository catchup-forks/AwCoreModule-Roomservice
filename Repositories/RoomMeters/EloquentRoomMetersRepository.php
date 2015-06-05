<?php
namespace AwCore\Modules\Roomservice\Repositories\RoomMeters;

use AwCore\Modules\Roomservice\Models\RoomMeters as RoomMeters;
use Repositories\AbstractEloquentRepository;
use AwCore\Modules\Roomservice\Repositories\RoomMeterTypes\RoomMeterTypesInterface as RoomMeterTypesInterface ;

use Input;
use Auth;

class EloquentRoomMetersRepository extends AbstractEloquentRepository implements RoomMetersInterface { 
 	/**
   	* @var Model
   	*/
  	protected $model;
 
  	/**
   	* Constructor
   	*/
  	public function __construct(RoomMeters $model, RoomMeterTypesInterface $meterTypes)
  	{
    	$this->model = $model; 
    	$this->meterTypes = $meterTypes;
  	}
	
	public function addToResultRow($row){
		if(!isset($this->alltypes)){ $this->alltypes = $this->meterTypes->all();}
		
		$key = $row['room_meter_type_id'];
        if(isset($this->alltypes[$key])){$row['room_meter_type_name'] = $this->alltypes[$key]['room_meter_type_name'];}
        else{$row['room_meter_type_name'] = "Unassigned";}
        		
		return $row;
	}
	
	public function saveMeterReadings(){
		$roomMeterTypes = $this->meterTypes->all();
		if(is_array($roomMeterTypes) && count($roomMeterTypes)){
			foreach($roomMeterTypes as $type){
				$reading = Input::get('meter_value_'.$type['room_meter_type_id']);
				if($reading){
					$save = new RoomMeters;
					$save->room_id = Input::get('room_id');
					$save->user_id = Auth::user()->id;
					$save->room_meter_type_id = $type['room_meter_type_id'];
					$save->room_meter_date = date("Y-m-d");
					$save->room_meter_value = $reading;
					//[[TODO]]
					$save->room_meter_increase = 0;
					$save->room_meter_days = 0;
					$save->room_meter_notes = "";
					$save->room_meter_photo = "";
					$save->save();
				}
			}
		}
		return(array("room_id"=>Input::get('room_id')));
	}
	public function addUpdatePost(){
		$arr = $this->_addUpdatePost();
		
		if (Input::hasFile('room_meter_photo'))
		{
			if (Input::file('room_meter_photo')->isValid())
			{
				$extension = Input::file('room_meter_photo')->getClientOriginalExtension();
				
				$destinationPath = 'uploads/meters'; // upload path
				$fileName = $arr['room_id']."-".$arr['room_meter_id']."-".time()."-".rand(111,999).'.'.$extension;
				Input::file('room_meter_photo')->move($destinationPath, $fileName);
				$room = RoomMeters::find($arr['room_meter_id']);
				$room->room_meter_photo = $fileName;
				$room->save();
			}
		}

		return $arr;
	}
 
}
