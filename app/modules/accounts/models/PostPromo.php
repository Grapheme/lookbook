<?php

class PostPromo extends BaseModel{

    protected $table = 'posts_promo';
    protected $guarded = array('id','_method','_token');
    protected $fillable = array('start_date','stop_date','position','order','link','photo_id','video');
    public static $rules = array();

    public function photo() {
        return $this->hasOne('Photo', 'id', 'photo_id');
    }
}