<?php 
namespace AwCore\Modules\Roomservice\Controllers;

use AwCore\Http\Controllers\BaseController as BaseController;

use AwCore\Modules\Roomservice\Repositories\Rooms\RoomsInterface as RoomsInterface ;
use AwCore\Modules\Roomservice\Repositories\RoomCharges\RoomChargesInterface as RoomChargesInterface ;

use Repositories\User\UserInterface as UsersInterface ;


use URL;
use Validator;
use Input;
use Redirect;
use View;
use Auth;


class RoomChargesController extends BaseController
{
	protected $layout = "layouts.main";

	public function __construct(RoomsInterface $rooms, RoomChargesInterface $roomCharges, UsersInterface $users) {

		parent::__construct();
		
		$this->rooms = $rooms;
		$this->roomCharges = $roomCharges;
		$this->users = $users;
		
		$this->beforeFilter('csrf', array('on'=>'post'));
   		$this->breadcrumbs[] = array(URL::to('rooms'), "Rooms");
   		
	}
	
	public function getIndex() {
		
    }
 
    public function getNew($id) {
    	if(!Auth::user()->level){ return Redirect::to('/rooms/'); }
		$room = $this->rooms->find($id);
		$roomCharge = $this->roomCharges->getEmptyArr();
		$roomCharge['room_id'] = $id;
		
		$this->doLayout("RoomserviceView::roomcharges.edit")
			->with("room", $room)
			->with("roomCharge", $roomCharge);
    }
    
    public function getEdit($id) {
    	if(!Auth::user()->level){ return Redirect::to('/rooms/'); }
    	$this->breadcrumbs[] = array(URL::to('roomcharges/edit/'.$id), "Edit");
        $roomCharge = $this->roomCharges->find($id);
        $room = $this->rooms->find($roomCharge['room_id']);
        
        $this->doLayout("RoomserviceView::roomcharges.edit")
			->with("room", $room)
			->with("roomCharge", $roomCharge);
        
        $this->title = "Edit Booking ".$room['room_name'];
    }
 
    public function getDelete($id) {
    	if(!Auth::user()->level){ return Redirect::to('/rooms/'); }
        $this->rooms->delete($id);
        return Redirect::to('/room')->with('message', 'Charge deleted!');
    }
 
 	public function postEdit($id){
 		return $this->_update($id);
 	}
 	
 	public function postNew(){
 		return $this->_update();
 	}
 	
    private function _update() {
    	if(!Auth::user()->level){ return Redirect::to('/rooms/'); }
    	$arr = $this->roomCharges->addUpdatePost();

        return Redirect::to('/rooms/view/'.$arr['room_id'])->with('message', 'Charge '.(($arr['saveaction']=="update")?'Updated':'Added').'!');
    }
    
}
