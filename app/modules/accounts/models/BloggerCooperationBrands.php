<?php

class BloggerCooperationBrands extends BaseModel {

    protected $table = 'user_cooperation_brands';
    protected $guarded = array('id','_method','_token');
    protected $fillable = array('user_id','cooperation_brand_id');
    public static $rules = array('user_id'=>'required','cooperation_brand_id'=>'required');

    public function user() {
        return $this->belongsTo('User', 'user_id');
    }
}