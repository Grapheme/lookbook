<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUserMonetizationTable extends Migration {

	public function up(){
		Schema::create('user_monetization', function(Blueprint $table){
			$table->increments('id');
            $table->integer('user_id')->unsigned()->nullable()->default(0);
            $table->text('cooperation_brands')->nullable();
            $table->text('thrust')->nullable();
            $table->text('features')->nullable();
            $table->string('phone',150)->nullable();
            $table->string('location',200)->nullable();
			$table->timestamps();
		});
	}

    public function down(){
		Schema::drop('user_monetization');
	}

}
