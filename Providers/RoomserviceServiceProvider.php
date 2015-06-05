<?php namespace AwCore\Modules\Roomservice\Providers;

use View;

class RoomserviceServiceProvider extends  \Illuminate\Support\ServiceProvider
{

	
    public function boot()
    {

        
    }

    public function register(){
 		$this->app->bind('AwCore\\Modules\\Roomservice\\Repositories\\Rooms\\RoomsInterface', 'AwCore\\Modules\\Roomservice\\Repositories\\Rooms\\EloquentRoomsRepository');
 		$this->app->bind('AwCore\\Modules\\Roomservice\\Repositories\\RoomBookings\\RoomBookingsInterface', 'AwCore\\Modules\\Roomservice\\Repositories\\RoomBookings\\EloquentRoomBookingsRepository');
 		$this->app->bind('AwCore\\Modules\\Roomservice\\Repositories\\RoomCharges\\RoomChargesInterface', 'AwCore\\Modules\\Roomservice\\Repositories\\RoomCharges\\EloquentRoomChargesRepository');
 		$this->app->bind('AwCore\\Modules\\Roomservice\\Repositories\\RoomMeters\\RoomMetersInterface', 'AwCore\\Modules\\Roomservice\\Repositories\\RoomMeters\\EloquentRoomMetersRepository');
 		$this->app->bind('AwCore\\Modules\\Roomservice\\Repositories\\RoomMeterTypes\\RoomMeterTypesInterface', 'AwCore\\Modules\\Roomservice\\Repositories\\RoomMeterTypes\\EloquentRoomMeterTypesRepository');
 		$this->app->bind('AwCore\\Modules\\Roomservice\\Repositories\\RoomChat\\RoomChatInterface', 'AwCore\\Modules\\Roomservice\\Repositories\\RoomChat\\EloquentRoomChatRepository');
   		View::addNamespace('RoomserviceView', __DIR__."/../Views/");
   		
		if(file_exists(__DIR__.'/../routes.php')) {
			include __DIR__.'/../routes.php';
		}
		if(is_dir(__DIR__.'/Views')) {
			$this->loadViewsFrom(__DIR__.'/Views', $module);
		}
    }
    
}
