<?php
namespace AwCore\Modules\Roomservice\Repositories\RoomBookings;

use AwCore\Modules\Roomservice\Models\RoomBookings as RoomBookings;
use AwCore\Modules\Roomservice\Models\Rooms as Rooms;
use Repositories\AbstractEloquentRepository;

class EloquentRoomBookingsRepository extends AbstractEloquentRepository implements RoomBookingsInterface { 
 	/**
   	* @var Model
   	*/
  	protected $model;
  	public $all_status = array(
  		0=>"Pre Booking",
  		1=>"Paid",
  		10=>"Accepted",
 		20=>"Intro Sent",
  		50=>"Checked in",
  		99=>"Checked out",
  		-1=>"Cancelled"
  	);
 
  	/**
   	* Constructor
   	*/
  	public function __construct(RoomBookings $model)
  	{
    	$this->model = $model; 
  	}
  	
	public function addToResultRow($row){
		$room = Rooms::find($row['room_id']);
        $row['room_name'] = $room->room_name;
        $row['room_village'] = $room->room_village;
        $row['room_book_start'] = date("jS M Y", strtotime($row['room_book_start']));
        $row['room_book_end'] = date("jS M Y", strtotime($row['room_book_end']));
        $st = $row['room_book_status'];
       	if(isset($this->all_status[$st])){ $row['status_name'] = $this->all_status[$st];}
        else{$row['status_name'] = "";}
        		
		return $row;
	}

  	
}
