<?php namespace AwCore\Modules\Roomservice;

use Illuminate\Support\ServiceProvider;
use View;


use AwCore\Modules\Roomservice\Controllers\RoomserviceController as RoomserviceController ;

use AwCore\Modules\Roomservice\Repositories\Rooms\RoomsInterface as RoomsInterface ;
use AwCore\Modules\Roomservice\Repositories\RoomBookings\RoomBookingsInterface as RoomBookingsInterface ;
use AwCore\Modules\Roomservice\Repositories\RoomCharges\RoomChargesInterface as RoomChargesInterface ;


class Roomservice extends ServiceProvider{

	private $control = NULL;
	
	public function __construct(RoomsInterface $rooms, RoomBookingsInterface $roomBookings, RoomChargesInterface $roomCharges) {
		
		$this->rooms = $rooms;
		$this->roomBookings = $roomBookings;
		$this->roomCharges = $roomCharges;
		

		
		$this->filters = array(
			"setProductName"=>"setProductName",
			"dashboardHeader"=>"getDashboardHeader",
			"dashboardContent"=>"getDashboardContent",
			"dashboardFooter"=>"getDashboardFooter",
			"getMenu_main"=>"getMenuMain",
			"getMenu_settings"=>"getMenuSettings",
			"userListView"=>"userListView",
			"userEditView"=>"userEditView"
			
		);
		$this->actions = array(
			"userEditSave"=>"userEditSave"
		);
	
	}
	
	public function register(){
	
	}


    public function setProductName($html){
    	return "Room Service";
    }
    
    public function getDashboardHeader($html){
    	if(!$this->control){$this->control  = new RoomserviceController($this, $this->rooms, $this->roomBookings, $this->roomCharges);}    	
    	return $this->control->getDashboardHeader($html);
    }
	public function getDashboardContent($html){
    	if(!$this->control){$this->control  = new RoomserviceController($this, $this->rooms, $this->roomBookings, $this->roomCharges);}
    	return $this->control->getDashboardContent($html);
    }
	public function getDashboardFooter($html){
    	if(!$this->control){$this->control  = new RoomserviceController($this, $this->rooms, $this->roomBookings, $this->roomCharges);}
    	return $this->control->getDashboardFooter($html);
    }
	public function getMenuMain($html){
    	if(!$this->control){$this->control  = new RoomserviceController($this, $this->rooms, $this->roomBookings, $this->roomCharges);}
    	return $this->control->getMenuMain($html);
    }
	public function getMenuSettings($html){
    	if(!$this->control){$this->control  = new RoomserviceController($this, $this->rooms, $this->roomBookings, $this->roomCharges);}
    	return $this->control->getMenuSettings($html);
    }
 	public function userListView($html, $user){
    	if(!$this->control){$this->control  = new RoomserviceController($this, $this->rooms, $this->roomBookings, $this->roomCharges);}
    	return $this->control->userListView($html, $user); 	
    }
 	public function userEditView($html, $user){
    	if(!$this->control){$this->control  = new RoomserviceController($this, $this->rooms, $this->roomBookings, $this->roomCharges);}
    	return $this->control->userEditView($html, $user); 	
    }
 	public function userEditSave($response, $user){
    	if(!$this->control){$this->control  = new RoomserviceController($this, $this->rooms, $this->roomBookings, $this->roomCharges);}
    	return $this->control->userEditSave($response, $user); 	
    }
   
}
