<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUserThrustTable extends Migration {

	public function up(){
		Schema::create('user_thrust', function(Blueprint $table){
			$table->increments('id');
            $table->integer('user_id')->unsigned()->nullable()->default(0);
            $table->integer('cooperation_brand_id')->unsigned()->nullable()->default(0);
			$table->timestamps();
		});
	}

    public function down(){
		Schema::drop('user_thrust');
	}

}
