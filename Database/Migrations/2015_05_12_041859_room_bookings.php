<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RoomBookings extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('rooms', function($table)
		{
			$table->increments('room_id');
			$table->integer('user_id');
			$table->string('room_name');
			$table->string('room_village');
			$table->decimal('room_lat', 15,10);
			$table->decimal('room_lng', 15,10);
			$table->string('room_photo');
			$table->boolean('room_active');
			$table->softDeletes();
			$table->timestamps();
		});

		Schema::create('room_bookings', function($table)
		{
			$table->increments('room_book_id');
			$table->integer('room_id');
			$table->date('room_book_start');
			$table->date('room_book_end');
			$table->integer('room_book_ppl');
			$table->string('room_book_name');
			$table->string('room_book_email');
			$table->decimal('room_book_deposit_due', 10,2);
			$table->decimal('room_book_deposit_collected', 10,2);
			$table->decimal('room_book_deposit_returned', 10,2);
			$table->integer('room_book_status');
			$table->text('room_book_notes');
			$table->softDeletes();
			$table->timestamps();
		});
		
		Schema::create('room_charges', function($table)
		{
			$table->increments('room_charge_id');
			$table->integer('room_id');
			$table->integer('user_id');
			$table->date('room_charge_date');
			$table->decimal('room_charge_amount', 10,2);
			$table->string('room_charge_desc');
			$table->softDeletes();
			$table->timestamps();
		});
		
		Schema::create('room_meters', function($table)
		{
			$table->increments('room_meter_id');
			$table->integer('room_id');
			$table->integer('user_id');
			$table->integer('room_meter_type_id');
			$table->date('room_meter_date');
			$table->decimal('room_meter_value', 15,2);
			$table->decimal('room_meter_increase', 15,2);
			$table->integer('room_meter_days');
			$table->string('room_meter_notes');
			$table->string('room_meter_photo');
			$table->softDeletes();
			$table->timestamps();
		});
		
		Schema::create('room_meter_types', function($table)
		{
			$table->increments('room_meter_type_id');
			$table->string('room_meter_type_name');
			$table->softDeletes();
			$table->timestamps();
		});
		
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('rooms');
		Schema::drop('room_bookings');
		Schema::drop('room_charges');
		Schema::drop('room_meters');
		Schema::drop('room_meter_types');
	}
}
