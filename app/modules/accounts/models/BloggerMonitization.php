<?php

class BloggerMonitization extends BaseModel {

    protected $table = 'user_monetization';
    protected $guarded = array();

    public function user() {

        return $this->belongsTo('User', 'user_id', 'id');
    }

}