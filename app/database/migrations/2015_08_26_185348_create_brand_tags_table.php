<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBrandTagsTable extends Migration {

	public function up(){
		Schema::create('brand_tags', function(Blueprint $table){
			$table->increments('id');
			$table->integer('user_id')->unsigned()->nullable()->default(0);
			$table->string('title', 128)->nullable();
			$table->integer('photo_id')->unsigned()->nullable();
			$table->timestamps();
		});
	}

	public function down(){
		Schema::drop('brand_tags');
	}
}
