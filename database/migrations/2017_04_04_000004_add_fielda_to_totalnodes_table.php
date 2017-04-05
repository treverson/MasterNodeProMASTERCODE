<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldaToTotalnodesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('totalnodes', function(Blueprint $table)
		{
			$table->text('data')->nullable();
			$table->integer('price')->default(0);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		 Schema::table('totalnodes', function(Blueprint $table)
		 {
		 	$table->dropColumn(array('data','price'));
		 });
	}

}
