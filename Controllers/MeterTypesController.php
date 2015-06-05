<?php 
namespace AwCore\Modules\Roomservice\Controllers;

use AwCore\Http\Controllers\BaseController as BaseController;

use AwCore\Modules\Roomservice\Repositories\RoomMeterTypes\RoomMeterTypesInterface as MeterTypesInterface ;

use Repositories\User\UserInterface as UsersInterface ;


use URL;
use Validator;
use Input;
use Redirect;
use View;
use Auth;


class MeterTypesController extends BaseController
{
	protected $layout = "layouts.main";

	public function __construct(MeterTypesInterface $metertypes, UsersInterface $users) {

		parent::__construct();
		
		$this->metertypes = $metertypes;
		$this->users = $users;
		$this->menu = "settings";
		
		$this->beforeFilter('csrf', array('on'=>'post'));
    	$this->breadcrumbs[] = array(URL::to('order'), "Orders");
    	
	}
	
	public function getIndex() {
		if(!Auth::user()->level){ return Redirect::to('/rooms/'); }
		$metertypes = $this->metertypes->all();
		
		$this->doLayout("RoomserviceView::metertypes.list")
			->with("metertypes", $metertypes);
    }
 
    public function getEdit($id) {
    	if(!Auth::user()->level){ return Redirect::to('/rooms/'); }
    	$this->breadcrumbs[] = array(URL::to('rooms/edit/'.$id), "Edit");
        $metertypes = $this->metertypes->find($id);
        
        $this->doLayout("RoomserviceView::metertypes.edit")
                ->with("metertypes", $metertypes);
        
        $this->title = "Edit Meter Type ".$metertypes['room_meter_type_name'];
    }
 
    public function getDelete($id) {
    	if(!Auth::user()->level){ return Redirect::to('/rooms/'); }
        $this->rooms->delete($id);
        return Redirect::to('/metertypes')->with('message', 'Meter Type deleted!');
    }
 
    public function getNew() {
    	if(!Auth::user()->level){ return Redirect::to('/rooms/'); }
        $this->doLayout("RoomserviceView::metertypes.edit")
                ->with("metertypes", $this->metertypes->getEmptyArr());
    }
 
 	public function postEdit($id){
 		return $this->_update($id);
 	}
 	
 	public function postNew(){
 		return $this->_update();
 	}
 	
    private function _update() {
    	if(!Auth::user()->level){ return Redirect::to('/rooms/'); }
    	$arr = $this->metertypes->addUpdatePost();

        return Redirect::to('/metertypes/')->with('message', 'Meter Type '.(($arr['saveaction']=="update")?'Updated':'Added').'!');
    }
    
}
