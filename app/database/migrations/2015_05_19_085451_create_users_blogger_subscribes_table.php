<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUsersBloggerSubscribesTable extends Migration {

	public function up(){
		Schema::create('users_blogger_subscribes', function(Blueprint $table){
			$table->increments('id');
            $table->integer('user_id')->unsigned()->nullable()->default(0);
            $table->integer('blogger_id')->unsigned()->nullable()->default(0);
			$table->timestamps();
		});
	}

	public function down(){
		Schema::drop('users_blogger_subscribes');
	}

}
