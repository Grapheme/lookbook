<?php

class BloggerCooperationBrands extends BaseModel {

    protected $table = 'user_cooperation_brands';
    protected $guarded = array();

    public function user() {

        return $this->belongsTo('User', 'user_id', 'id');
    }

}