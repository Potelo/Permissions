<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePermissionRoleTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if(!Schema::hasTable('permission_role'))
        {
            Schema::create('permission_role', function($table)
            {
                $table->increments('id');
                $table->integer('role_id');
                $table->integer('permission_id');
                $table->index(['role_id', 'permission_id']);
            });
        }
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('permission_role');
	}

}
