<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFleets extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('fleets', function($table){
			$table->increments('id');
			$table->string('name')->nullable();
			$table->string('owner')->nullable();
			$table->enum('relationship',array('friend','neutral','enemy','uknown'));
			$table->string('empire');
			$table->string('faction');
			$table->integer('ships');
			$table->float('tonnage');
			$table->integer('warfacts_id')->nullable();
			$table->integer('x');
			$table->integer('y');
			$table->integer('z');
			$table->dateTime('position_updated_at');
			$table->integer('previous_x')->nullable();
			$table->integer('previous_y')->nullable();
			$table->integer('previous_z')->nullable();
			$table->dateTime('previous_position_updated_at')->nullable();
			$table->integer('speed')->nullable();
			$table->enum('speed_knowledge',array('exact','estimation','maximum','uknown'))->nullable();
			$table->integer('vector_x')->nullable();
			$table->integer('vector_y')->nullable();
			$table->integer('vector_z')->nullable();
			$table->string('destination')->nullable();
			$table->text('old_positions')->nullable();
			$table->text('battlelogs')->nullable();
			$table->text('notes')->nullable();
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
		Schema::drop('fleets');
	}

}
