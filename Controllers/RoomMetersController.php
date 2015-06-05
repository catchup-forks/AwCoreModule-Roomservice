<?php 
namespace AwCore\Modules\Roomservice\Controllers;

use AwCore\Http\Controllers\BaseController as BaseController;

use AwCore\Modules\Roomservice\Repositories\Rooms\RoomsInterface as RoomsInterface ;
use AwCore\Modules\Roomservice\Repositories\RoomMeters\RoomMetersInterface as RoomMetersInterface ;
use AwCore\Modules\Roomservice\Repositories\RoomMeterTypes\RoomMeterTypesInterface as RoomMeterTypesInterface ;

use Repositories\User\UserInterface as UsersInterface ;


use URL;
use Validator;
use Input;
use Redirect;
use View;
use Auth;

class RoomMetersController extends BaseController
{
	protected $layout = "layouts.main";

	public function __construct(RoomsInterface $rooms, RoomMetersInterface $roomMeters, RoomMeterTypesInterface $roomMeterTypes, UsersInterface $users) {

		parent::__construct();
		
		$this->rooms = $rooms;
		$this->roomMeters = $roomMeters;
		$this->roomMeterTypes = $roomMeterTypes;
		$this->users = $users;
		
		$this->beforeFilter('csrf', array('on'=>'post'));
    	$this->breadcrumbs[] = array(URL::to('rooms'), "Rooms");
    	
	}
	
	public function getIndex() {
		
    }
 
    public function getNew($id) {
    	if(!Auth::user()->level){ return Redirect::to('/rooms/'); }
    	
		$room = $this->rooms->find($id);
		$roomMeter = $this->roomMeters->getEmptyArr();
		$roomMeter['room_id'] = $id;
		$roomMeterTypes = $this->roomMeterTypes->all();
		
		$this->doLayout("RoomserviceView::roommeters.new")
			->with("room", $room)
			->with("roomMeter", $roomMeter)
			->with("roomMeterTypes", $roomMeterTypes);
    }
    
    public function getEdit($id) {
    	if(!Auth::user()->level){ return Redirect::to('/rooms/'); }
    	
    	$this->breadcrumbs[] = array(URL::to('roommeters/edit/'.$id), "Edit");
        $roomMeter = $this->roomMeters->find($id);
        $room = $this->rooms->find($roomMeter['room_id']);
		$roomMeterTypes = $this->roomMeterTypes->all();
		$roomMeterTypes[0]['room_meter_type_name'] = '';
		$roomMeterTypesSel = $this->roomMeterTypes->allMeterTypesSelectArr();
       
        $this->doLayout("RoomserviceView::roommeters.edit")
			->with("room", $room)
			->with("roomMeter", $roomMeter)
			->with("roomMeterTypes", $roomMeterTypes)
			->with("roomMeterTypesSel", $roomMeterTypesSel);
        
        $this->title = "Edit Booking ".$room['room_name'];
    }
 
    public function getDelete($id) {
    	if(!Auth::user()->level){ return Redirect::to('/rooms/'); }
        $this->rooms->delete($id);
        return Redirect::to('/room')->with('message', 'Booking deleted!');
    }
 
 	public function postEdit($id){
 		return $this->_update($id);
 	}
 	
 	public function postNew(){
 		if(!Auth::user()->level){ return Redirect::to('/rooms/'); }
 		$arr = $this->roomMeters->saveMeterReadings();

        return Redirect::to('/rooms/view/'.$arr['room_id'])->with('message', 'Meter Added!');
 	}
 	
    private function _update() {
    	if(!Auth::user()->level){ return Redirect::to('/rooms/'); }
    	$arr = $this->roomMeters->addUpdatePost();

        return Redirect::to('/rooms/view/'.$arr['room_id'])->with('message', 'Meter Updated!');
    }
    
}
