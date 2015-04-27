<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddUsersFields extends Migration {

	public function up(){
		Schema::table('users', function(Blueprint $table){
            $table->boolean('first_login')->after('active')->default(1)->unsigned()->nullable();
            $table->string('birth',20)->after('active')->nullable();
            $table->string('location',200)->after('active')->nullable();
            $table->string('links',255)->after('active')->nullable();
            $table->string('site',100)->after('active')->nullable();
            $table->string('inspiration',255)->after('active')->nullable();
            $table->string('phone',150)->after('active')->nullable();
            $table->string('blogname',100)->after('active')->nullable();
            $table->string('blogpicture',100)->after('active')->nullable();
            $table->text('about')->after('active')->nullable();
            $table->boolean('brand')->after('active')->default(0)->unsigned()->nullable();
		});
	}

	public function down(){
		Schema::table('users', function(Blueprint $table){
            $table->dropColumn('first_login');
            $table->dropColumn('birth');
            $table->dropColumn('location');
            $table->dropColumn('links');
            $table->dropColumn('site');
            $table->dropColumn('inspiration');
            $table->dropColumn('phone');
            $table->dropColumn('blogname');
            $table->dropColumn('blogpicture');
            $table->dropColumn('about');
            $table->dropColumn('brand');
		});
	}

}
