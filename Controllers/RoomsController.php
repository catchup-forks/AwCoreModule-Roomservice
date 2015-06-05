<?php 
namespace AwCore\Modules\Roomservice\Controllers;

use AwCore\Http\Controllers\BaseController as BaseController;

use AwCore\Modules\Roomservice\Repositories\Rooms\RoomsInterface as RoomsInterface ;
use AwCore\Modules\Roomservice\Repositories\RoomBookings\RoomBookingsInterface as RoomBookingsInterface ;
use AwCore\Modules\Roomservice\Repositories\RoomCharges\RoomChargesInterface as RoomChargesInterface ;
use AwCore\Modules\Roomservice\Repositories\RoomMeters\RoomMetersInterface as RoomMetersInterface ;
use AwCore\Modules\Roomservice\Repositories\RoomChat\RoomChatInterface as RoomChatInterface ;

use Repositories\User\UserInterface as UsersInterface ;


use URL;
use Validator;
use Input;
use Redirect;
use View;
use Auth;



class RoomsController extends BaseController
{
	protected $layout = "layouts.main";

	public function __construct(RoomsInterface $rooms, RoomBookingsInterface $roomBookings, RoomChargesInterface $roomCharges, RoomMetersInterface $roomMeters, RoomChatInterface $roomChat, UsersInterface $users) {

		parent::__construct();
		
		$this->rooms = $rooms;
		$this->roomBookings = $roomBookings;
		$this->roomCharges = $roomCharges;
		$this->roomMeters = $roomMeters;
		$this->roomChat = $roomChat;
		$this->users = $users;
		
		$this->beforeFilter('csrf', array('on'=>'post'));
      	$this->breadcrumbs[] = array(URL::to('rooms'), "Rooms");    	
	}
	
	public function getIndex() {
		if(Auth::user()->level){
			$rooms = $this->rooms->all();
		}else{
			$rooms = $this->rooms->getWhere("user_id", "=", Auth::user()->id);
		}
		
		$this->doLayout("RoomserviceView::rooms.list")
			->with("rooms", $rooms)
			->with("is_admin", Auth::user()->level);
    }
 
    public function getView($id) {
    	if(!$this->checkIsAuth($id)) return Redirect::to('/rooms/');;
		$room = $this->rooms->find($id);
		
		$roomBookings_active = $this->roomBookings
			->setOrder("room_book_start", "asc")->setWhere("room_book_start", "<=", date("Y-m-d"))->setWhere("room_book_end", ">=", date("Y-m-d"))->getWhere("room_id", "=", $id);
		$roomBookings_future = $this->roomBookings
			->setOrder("room_book_start", "asc")->setWhere("room_book_start", ">", date("Y-m-d"))->getWhere("room_id", "=", $id);
		$roomBookings_past = $this->roomBookings
			->setOrder("room_book_start", "asc")->setWhere("room_book_end", "<", date("Y-m-d"))->getWhere("room_id", "=", $id);

		$roomCharges = $this->roomCharges->getWhere("room_id", "=", $id);
		$roomMeters = $this->roomMeters->getWhere("room_id", "=", $id);
		$roomChat = $this->roomChat->setOrder("created_at", "desc")->getWhere("room_id", "=", $id);
		
		$this->doLayout("RoomserviceView::rooms.view")
			->with("room", $room)
			->with("roomBookings_active", $roomBookings_active)
			->with("roomBookings_future", $roomBookings_future)
			->with("roomBookings_past", $roomBookings_past)
			->with("roomCharges", $roomCharges)
			->with("roomMeters", $roomMeters)
			->with("is_admin", Auth::user()->level)
			->with("roomChat", $roomChat);
			
		$this->title = "View Room ".$room['room_name'];
    }
    
    public function getEdit($id) {
    	if(!$this->checkIsAuth($id, true)) return Redirect::to('/rooms/view/'.$id);;
    	$this->breadcrumbs[] = array(URL::to('rooms/edit/'.$id), "Edit");
        $room = $this->rooms->find($id);
        $allUsers = $this->users->allUserSelectArr();
        
        $this->doLayout("RoomserviceView::rooms.edit")
                ->with("room", $room)
                ->with("allUsers", $allUsers);
        
        $this->title = "Edit Room ".$room['room_name'];
    }
 
    public function getDelete($id) {
	    if(!$this->checkIsAuth($id, true)) return Redirect::to('/rooms/view/'.$id);;
        $this->rooms->delete($id);
        return Redirect::to('/room')->with('message', 'Room deleted!');
    }
 
    public function getNew() {
    	if(!$this->checkIsAuth(false, true)) return Redirect::to('/rooms/view/'.$id);
    	$allUsers = $this->users->allUserSelectArr();
    	$room = $this->rooms->getEmptyArr();
    	$room['room_lat'] = "12.047916";
    	$room['room_lng'] = "102.323482";
        $this->doLayout("RoomserviceView::rooms.edit")
                ->with("room", $room)
                ->with("allUsers", $allUsers);
    }
 
 	public function postEdit($id){
 		return $this->_update($id);
 	}
 	
 	public function postNew(){
 		return $this->_update();
 	}
 	
    private function _update() {
    	if(!$this->checkIsAuth(Input::get('room_id'), true)) return Redirect::to('/rooms/view/'.Input::get('room_id'));;
    	$arr = $this->rooms->addUpdatePost();

        return Redirect::to('/rooms/view/'.$arr['room_id'])->with('message', 'Room '.(($arr['saveaction']=="update")?'Updated':'Added').'!');
    }
    
    private function checkIsAuth($id, $edit=false){
    	if(Auth::user()->level){ return true; }
    	if(!$id) return false;
    	$room = $this->rooms->find($id);
    	if(($room['user_id'] == Auth::user()->id) || ($edit == false)){ return true; }
    	return false;
    }
	
	
	public function postAddchat(){
		$msg = 'Error saving chat!';
		if(Input::has('room_id')){
			$room_id = Input::get('room_id');
			if(Input::has('add_chat')){
				$chat = Input::get('add_chat');
				$this->roomChat->addChat($room_id, $chat);
				$msg = 'Chat Added!';
			}
			return Redirect::to('/rooms/view/'.$room_id)->with('message', $msg);
		}
		return Redirect::to('/rooms/')->with('message', $msg);
	}
	
    public function getExportcharges($id) {
    	if(!$this->checkIsAuth($id, true)) return Redirect::to('/rooms/view/'.$id);;
		
		header("Content-Type: text/csv");
		header("Content-Disposition: attachment; filename=file.csv");
		header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1
		header("Pragma: no-cache"); // HTTP 1.0
		header("Expires: 0"); // Proxies

		function outputCSV($data) {
			$output = fopen("php://output", "w");
			foreach ($data as $row) {
				fputcsv($output, $row); // here you can change delimiter/enclosure
			}
			fclose($output);
		}
		$roomCharges = $this->roomCharges->prepareCSV($id);
		outputCSV($roomCharges);
		/*
		outputCSV(array(
			array("name 1", "age 1", "city 1"),
			array("name 2", "age 2", "city 2"),
			array("name 3", "age 3", "city 3")
		));
		*/
		
		die();
    }
}
