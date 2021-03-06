<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePostsTable extends Migration {


	public function up(){
		Schema::create('posts', function(Blueprint $table){
			$table->increments('id');
            $table->integer('user_id')->unsigned()->nullable()->default(0);
            $table->integer('category_id')->unsigned()->nullable()->default(0);
            $table->date('publish_at')->nullable();
            $table->string('title', 128)->nullable();
            $table->text('content')->nullable();
            $table->integer('photo_id')->unsigned()->nullable();
            $table->string('photo_title', 128)->nullable();
            $table->integer('gallery_id')->unsigned()->nullable();
            $table->boolean('publication')->default(0)->unsigned()->nullable();
            $table->boolean('in_index')->default(0)->unsigned()->nullable();
            $table->boolean('in_section')->default(0)->unsigned()->nullable();
            $table->boolean('in_promoted')->default(0)->unsigned()->nullable();
            $table->boolean('in_advertising')->default(0)->unsigned()->nullable();
            $table->integer('promoted_photo_id')->unsigned()->nullable();
            $table->integer('guest_views')->default(0)->unsigned()->nullable();
			$table->timestamps();
		});
	}

	public function down(){
		Schema::drop('posts');
	}

}
