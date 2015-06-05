<?php
namespace AwCore\Modules\Roomservice\Repositories\Rooms;

use AwCore\Modules\Roomservice\Models\Rooms as Rooms;
use AwCore\Modules\Roomservice\Models\RoomCharges as RoomCharges;
use AwCore\Modules\Roomservice\Models\RoomBookings as RoomBookings;
use Repositories\AbstractEloquentRepository;

use Repositories\User\UserInterface as UserInterface ;

use Input;

class EloquentRoomsRepository extends AbstractEloquentRepository implements RoomsInterface { 
 	/**
   	* @var Model
   	*/
  	protected $model;
  	protected $allstaff;
 
  	/**
   	* Constructor
   	*/
  	public function __construct(Rooms $model, UserInterface $user)
  	{
    	$this->model = $model; 
    	$this->user = $user;
  	}
 
	public function addToResultRow($row){
		if(!$this->allstaff){ $this->allstaff = $this->user->all();}
		$key = $row['user_id'];
        if(isset($this->allstaff[$key])){$row['owner_name'] = $this->allstaff[$key]['firstname']." ".$this->allstaff[$key]['lastname'];}
        else{$row['owner_name'] = "Unassigned";}

        $next = RoomBookings::where("room_id", "=", $row['room_id'])->where("room_book_start", ">=", date("Y-m-d"))->orderBy("room_book_start", "ASC")->first();
        if($next['room_book_start']){$row['next_booking'] = date("jS M Y", strtotime($next['room_book_start']));}
        else{$row['next_booking'] = "None";}
        		
        $charges = RoomCharges::where("room_id", "=", $row['room_id']);
        $row['balance'] = $charges->sum("room_charge_amount");
        		
		return $row;
	}

	
	
	public function addUpdatePost(){
		$arr = $this->_addUpdatePost();
		
		if (Input::hasFile('room_photo'))
		{
			if (Input::file('room_photo')->isValid())
			{
				//$path = Input::file('room_photo')->getRealPath();
				//$name = Input::file('room_photo')->getClientOriginalName();
				$extension = Input::file('room_photo')->getClientOriginalExtension();
				
				$destinationPath = 'uploads/rooms'; // upload path
				$fileName = $arr['room_id']."-".time()."-".rand(111,999).'.'.$extension;
				Input::file('room_photo')->move($destinationPath, $fileName);
				$room = Rooms::find($arr['room_id']);
				$room->room_photo = $fileName;
				$room->save();
			}
		}

		return $arr;
	}
}
