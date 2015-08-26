<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBrandTagsTable extends Migration {

	public function up(){
		Schema::create('brand_tags', function(Blueprint $table){
			$table->increments('id');
			$table->string('title', 128)->nullable();
			$table->integer('photo_id')->unsigned()->nullable();
			$table->timestamps();
		});
	}

	public function down(){
		Schema::drop('brand_tags');
	}

}
