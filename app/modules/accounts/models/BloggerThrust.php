<?php

class BloggerThrust extends BaseModel {

    protected $table = 'user_thrust';
    protected $guarded = array('id','_method','_token');
    protected $fillable = array('user_id','thrust_id');
    public static $rules = array('user_id'=>'required','thrust_id'=>'required');

    public function user() {
        return $this->belongsTo('User', 'user_id');
    }

}