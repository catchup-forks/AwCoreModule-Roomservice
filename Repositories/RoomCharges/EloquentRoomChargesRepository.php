<?php
namespace AwCore\Modules\Roomservice\Repositories\RoomCharges;

use AwCore\Modules\Roomservice\Models\RoomCharges as RoomCharges;
use Repositories\AbstractEloquentRepository;
use Repositories\User\UserInterface as UserInterface ;


class EloquentRoomChargesRepository extends AbstractEloquentRepository implements RoomChargesInterface { 
 	/**
   	* @var Model
   	*/
  	protected $model;
 
  	/**
   	* Constructor
   	*/
  	public function __construct(RoomCharges $model, UserInterface $user)
  	{
    	$this->model = $model; 
    	$this->user = $user;
  	}
 
	
	public function prepareCSV($id){
		$raw = $this->model->orderBy("room_charge_date", "asc")->where("room_id", "=", $id)->get()->toArray();
		$allusers = $this->user->all();
		$arr = array();
		$balance = 0;
		
		if(is_array($raw) && count($raw)){
			foreach($raw as $r){
				$balance = $balance + $r['room_charge_amount'];
				
				$key = $r['user_id'];
				if(isset($allusers[$key])){$user = $allusers[$key]['firstname']." ". $allusers[$key]['lastname'];}
				else{$user = "Unknown";}
				
				$row = array(
					$r['room_charge_date'],
					$r['room_charge_amount'],
					round($balance,2),
					$r['room_charge_desc'],
					$user
				);
				$arr[] = $row;
			}
			$arr[] = array("Date", "Amount", "Balance", "Description", "Staff");
		}
		
		return array_reverse($arr);		
	}
 
}
