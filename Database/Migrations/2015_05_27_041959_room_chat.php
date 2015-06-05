<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RoomChat extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('room_chat', function($table)
		{
			$table->increments('room_chat_id');
			$table->integer('user_id');
			$table->integer('room_id');
			$table->text('room_chat');
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
		Schema::drop('room_chat');
	}
}
