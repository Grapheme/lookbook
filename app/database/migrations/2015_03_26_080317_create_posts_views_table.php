<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePostsViewsTable extends Migration {

		public function up(){
		Schema::create('posts_views', function(Blueprint $table){
            $table->increments('id');
            $table->integer('post_id')->unsigned()->nullable()->default(0);
            $table->integer('user_id')->unsigned()->nullable()->default(0);
            $table->timestamps();
		});
	}

	public function down(){
		Schema::drop('posts_views');
	}

}
