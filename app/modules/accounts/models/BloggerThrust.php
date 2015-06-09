<?php

class BloggerThrust extends BaseModel {

    protected $table = 'user_thrust';
    protected $guarded = array();

    public function user() {

        return $this->belongsTo('User', 'user_id', 'id');
    }

}