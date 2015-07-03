<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePromoPostTable extends Migration {

	public function up(){
		Schema::create('posts_promo', function(Blueprint $table){
			$table->increments('id');
            $table->timestamp('start_date')->default('0000-00-00 00:00:00')->nullable();
            $table->timestamp('stop_date')->default('0000-00-00 00:00:00')->nullable();
            $table->tinyInteger('position')->default(0)->unsigned()->nullable();
            $table->integer('order')->default(0)->unsigned()->nullable();
            $table->string('link',255)->nullable();
            $table->integer('photo_id')->unsigned()->nullable();
            $table->text('video')->nullable();
			$table->timestamps();
		});
	}

	public function down(){
		Schema::drop('posts_promo');
	}

}
