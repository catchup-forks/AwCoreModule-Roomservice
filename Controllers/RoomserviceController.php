<?php 
namespace AwCore\Modules\Roomservice\Controllers;

use AwCore\Http\Controllers\BaseController as BaseController;

use AwCore\Modules\Roomservice\Roomservice as Roomservice;


use AwCore\Modules\Roomservice\Repositories\Rooms\RoomsInterface as RoomsInterface ;
use AwCore\Modules\Roomservice\Repositories\RoomBookings\RoomBookingsInterface as RoomBookingsInterface ;
use AwCore\Modules\Roomservice\Repositories\RoomCharges\RoomChargesInterface as RoomChargesInterface ;

use URL;
use Validator;
use Input;
use Redirect;
use View;
use Auth;


class RoomserviceController extends BaseController
{

	protected $layout = "layouts.main";

	public function __construct(Roomservice $roomservice, RoomsInterface $rooms, RoomBookingsInterface $roomBookings, RoomChargesInterface $roomCharges) {

		parent::__construct();
		
		$this->rooms = $rooms;
		$this->roomBookings = $roomBookings;
		$this->roomCharges = $roomCharges;
		
		$this->beforeFilter('csrf', array('on'=>'post'));
    	$this->breadcrumbs[] = array(URL::to('order'), "Orders");
    	
	}
    
    public function getDashboardHeader($html){
    	if(Auth::user()->level){$title = "Admin Dashboard";}
    	else{$title = "My properties";}
    	return $html."<h1>".$title."</h1>";
    }
    public function getDashboardContent($html){
    	if(Auth::user()->level){

    		$checkins = $this->roomBookings->setOrder("room_book_start", "asc")->take(20)->setWhere("room_book_status", ">=", 1)->getWhere("room_book_start", ">=", date("Y-m-d"));
    		$checkouts = $this->roomBookings->setOrder("room_book_end", "asc")->take(20)->setWhere("room_book_status", ">=", 1)->getWhere("room_book_end", ">=", date("Y-m-d"));
   			$latest = $this->roomBookings->setOrder("created_at", "desc")->take(20)->getWhere("room_book_status", ">=", 0);
    		$balances = $this->rooms->all();
    		
			$html .= View::make("RoomserviceView::dashboard")
				->with("checkins", $checkins)
				->with("checkouts", $checkouts)
				->with("balances", $balances)
				->with("latest", $latest);
    	}else{
    		$checkins = $this->roomBookings->setOrder("room_book_start", "asc")->take(20)
    		->join('rooms', 'rooms.room_id', '=', 'room_bookings.room_id')->setWhere("rooms.user_id", "=", Auth::user()->id)
    		->setWhere("room_book_status", ">=", 1)->getWhere("room_book_start", ">=", date("Y-m-d"));
    		$checkouts = $this->roomBookings->setOrder("room_book_end", "asc")->take(20)
    		->join('rooms', 'rooms.room_id', '=', 'room_bookings.room_id')->setWhere("rooms.user_id", "=", Auth::user()->id)
    		->setWhere("room_book_status", ">=", 1)->getWhere("room_book_end", ">=", date("Y-m-d"));
    		$latest = $this->roomBookings->setOrder("room_bookings.created_at", "desc")->take(20)
    		->join('rooms', 'rooms.room_id', '=', 'room_bookings.room_id')->setWhere("rooms.user_id", "=", Auth::user()->id)
    		->getWhere("room_book_status", ">=", 0);
    		$balances = $this->rooms->getWhere("user_id", "=", Auth::user()->id);

			$html .= View::make("RoomserviceView::dashboard")
				->with("checkins", $checkins)
				->with("checkouts", $checkouts)
				->with("balances", $balances)
				->with("latest", $latest);
    	}
    	return $html;
    }
    public function getDashboardFooter($html){
    	return $html;
    }
    public function getMenuMain($html){ 	
    	return $html.'<li><a href="#" class="dropdown-toggle"><i class="fa fa-bed"></i><span class="hidden-xs">Rooms</span></a>
    		<ul class="dropdown-menu">
    			<li><a href="'.URL::to('rooms').'">View Rooms</span></a></li>'
    			.((Auth::check() && Auth::user()->level)?'<li><a href="'.URL::to('rooms/new').'">Add Room</span></a></li>':'')
    		.'</ul>
    	</li>';
    }
    public function getMenuSettings($html){
    	if(!Auth::check()){return "";}
    	if(!Auth::user()->level){
    		return '<li><a href="'.URL::to('user/edit/'.Auth::user()->id).'"><i class="fa fa-users"></i>Profile</span></a></li>';
    	}
    	return $html.'<li><a href="'.URL::to('metertypes').'"><i class="fa fa-meter"></i><span class="hidden-xs">Meter Types</span></a></li>';
    }
    public function userListView($arr, $users){
    	$arr['row_head'] = "<th>Permissions</th>"; 	
    	if(is_array($users) && count($users)){
    		foreach($users as $user){
    			$arr['row_body'][] = "<td>".(($user['level'])?"Admin":"Normal")."</td>";
    		}
    	}
    	return $arr;
    }
    public function userEditView($html, $user){
    	$is_admin = (($user['level'])?true:false);
    	if(!Auth::user()->level){return "";}
    	$html .= View::make("RoomserviceView::edituserfields")
    		->with("is_admin", $is_admin);
    	return $html;
    }
    public function userEditSave($response, $user){
    	if(Input::get('is_admin')) $user->level = Input::get('is_admin');
    	$user->save();
    }
}
