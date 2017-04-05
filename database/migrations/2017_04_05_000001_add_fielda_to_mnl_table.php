<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldaToMnlTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('masternodelist', function(Blueprint $table)
		{
			$table->integer('total')->default(0);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		 Schema::table('blocks', function(Blueprint $table)
		 {
		 	$table->dropColumn(array('total'));
		 });
	}

}
