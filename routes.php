<?php

Route::group(array('module'=>'Roomservice','namespace' => 'AwCore\Modules\Roomservice\Controllers'), function() {

    //Your routes belong to this module.
	Route::group(['middleware' => 'auth'], function()
	{
		Route::controller('rooms', 'RoomsController');
		Route::controller('roombookings', 'RoomBookingsController');
		Route::controller('roomcharges', 'RoomChargesController');
		Route::controller('roommeters', 'RoomMetersController');
		Route::controller('metertypes', 'MeterTypesController');
	});  
    
});


