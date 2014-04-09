<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddInSystemAndGalaxyColumnsToFleets extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('fleets', function($table)
			{
			    $table->string('system')->after('z')->nullable();
			    $table->string('galaxy')->after('system');
			});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{

		Schema::table('fleets', function($table)
		{
		    $table->dropColumn('system', 'galaxy');
		});
	}

}
