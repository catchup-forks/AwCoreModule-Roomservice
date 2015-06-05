<?php
namespace AwCore\Modules\Roomservice\Repositories\RoomChat;

use AwCore\Modules\Roomservice\Models\RoomChat as RoomChat;
use Repositories\AbstractEloquentRepository;

use Repositories\User\UserInterface as UserInterface ;

use Input;
use Auth;

class EloquentRoomChatRepository extends AbstractEloquentRepository implements RoomChatInterface { 
 	/**
   	* @var Model
   	*/
  	protected $model;
  	protected $allstaff;
 
  	/**
   	* Constructor
   	*/
  	public function __construct(RoomChat $model, UserInterface $user)
  	{
    	$this->model = $model; 
    	$this->user = $user;
  	}
 
	public function addToResultRow($row){
		if(!isset($this->allusers)){ $this->allusers = $this->user->all();}
		
		$key = $row['user_id'];
        if(isset($this->allusers[$key])){$row['user_name'] = $this->allusers[$key]['firstname']." ". $this->allusers[$key]['lastname'];}
        else{$row['user_name'] = "Unknown";}
		$row['chat_date'] = date("jS M Y", strtotime($row['created_at']));
        		
		return $row;
	}

	public function addChat($room_id, $chat){
		$add_chat = new $this->model;
		$add_chat->user_id = Auth::user()->id;
		$add_chat->room_id = $room_id;
		$add_chat->room_chat = $chat;
		$add_chat->save();
	}
	
	
	
}
