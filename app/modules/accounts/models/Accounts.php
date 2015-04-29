<?php

class Accounts extends BaseModel {

	protected $table = 'users';

	protected $guarded = array();

	protected $hidden = array('password');

    public function posts(){

        return $this->hasMany('Post','user_id','id');
    }
}