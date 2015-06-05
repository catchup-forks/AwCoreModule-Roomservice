<?php 
namespace AwCore\Modules\Roomservice\Controllers;

use AwCore\Http\Controllers\BaseController as BaseController;

use AwCore\Modules\Roomservice\Repositories\Rooms\RoomsInterface as RoomsInterface ;
use AwCore\Modules\Roomservice\Repositories\RoomBookings\RoomBookingsInterface as RoomBookingsInterface ;

use Repositories\User\UserInterface as UsersInterface ;


use URL;
use Validator;
use Input;
use Redirect;
use View;
use Auth;



class RoomBookingsController extends BaseController
{
	protected $layout = "layouts.main";

	public function __construct(RoomsInterface $rooms, RoomBookingsInterface $roomBookings, UsersInterface $users) {

		parent::__construct();
		
		$this->rooms = $rooms;
		$this->roomBookings = $roomBookings;
		$this->users = $users;
		
		$this->beforeFilter('csrf', array('on'=>'post'));
   		$this->breadcrumbs[] = array(URL::to('rooms'), "Rooms");
    	
	}
	
	public function getIndex() {
		
    }
 
    public function getNew($id) {
		$room = $this->rooms->find($id);
		$roomBooking = $this->roomBookings->getEmptyArr();
		$roomBooking['room_id'] = $id;
		$all_status = $this->roomBookings->all_status;
		
		$this->doLayout("RoomserviceView::roombookings.edit")
			->with("room", $room)
			->with("all_status", $all_status)
			->with("roomBooking", $roomBooking);
    }
    
    public function getEdit($id) {
    	$this->breadcrumbs[] = array(URL::to('roombookings/edit/'.$id), "Edit");
        $roomBooking = $this->roomBookings->find($id);
        $room = $this->rooms->find($roomBooking['room_id']);
        $all_status = $this->roomBookings->all_status;
        
    	if(!(Auth::user()->level || ($room['user_id'] == Auth::user()->id) )){ return Redirect::to('/rooms/view/'.$room['room_id']); }
        
        $this->doLayout("RoomserviceView::roombookings.edit")
			->with("room", $room)
			->with("all_status", $all_status)
			->with("roomBooking", $roomBooking);
        
        $this->title = "Edit Booking ".$roomBooking['room_book_name'];
    }
 
    public function getDelete($id) {
    	$roomBooking = $this->roomBookings->find($id);
        $room = $this->rooms->find($roomBooking['room_id']);
    	if(!(Auth::user()->level || ($room['user_id'] == Auth::user()->id) )){ return Redirect::to('/rooms/view/'.$room['room_id']); }
    	
        $this->roomBookings->delete($id);
        return Redirect::to('/room')->with('message', 'Booking deleted!');
    }
 
 	public function postEdit($id){
 		$roomBooking = $this->roomBookings->find($id);
        $room = $this->rooms->find($roomBooking['room_id']);
 		if(!(Auth::user()->level || ($room['user_id'] == Auth::user()->id) )){ return Redirect::to('/rooms/view/'.$room['room_id']); }
 		return $this->_update($id);
 	}
 	
 	public function postNew(){
 		return $this->_update();
 	}
 	
    private function _update() {
    	$arr = $this->roomBookings->addUpdatePost();

        return Redirect::to('/rooms/view/'.$arr['room_id'])->with('message', 'Booking '.(($arr['saveaction']=="update")?'Updated':'Added').'!');
    }
    
}
