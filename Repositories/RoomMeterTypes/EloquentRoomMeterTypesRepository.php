<?php
namespace AwCore\Modules\Roomservice\Repositories\RoomMeterTypes;

use AwCore\Modules\Roomservice\Models\RoomMeterTypes as RoomMeterTypes;
use Repositories\AbstractEloquentRepository;

class EloquentRoomMeterTypesRepository extends AbstractEloquentRepository implements RoomMeterTypesInterface { 
 	/**
   	* @var Model
   	*/
  	protected $model;
 
  	/**
   	* Constructor
   	*/
  	public function __construct(RoomMeterTypes $model)
  	{
    	$this->model = $model; 
  	}
 
	public function allMeterTypesSelectArr(){
		$all = $this->model->all();
		//$arr = array('0'=>"No Country");
		foreach($all as $k=>$v){
			$arr[$v['room_meter_type_id']] = $v['room_meter_type_name'];
		}
		return $arr;
	}  
}
