<?php

class Accounts extends BaseModel {

    protected $table = 'users';

    protected $guarded = array();

    protected $hidden = array('password');

    public function posts() {

        return $this->hasMany('Post', 'user_id', 'id');
    }

    public function me_signed() {

        return $this->belongsToMany('User', 'users_blogger_subscribes', 'blogger_id', 'user_id');
    }

    public function monetization() {

        return $this->hasOne('BloggerMonitization', 'user_id', 'id');
    }

}