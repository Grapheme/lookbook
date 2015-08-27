<?php

class BrandTags extends BaseModel {

    protected $table = 'brand_tags';
    protected $guarded = array('id','_method','_token');
    protected $fillable = array('title','photo_id');
    public static $rules = array('tag_title'=>'required','tag_photo'=>'');

    public $timestamps = false;

    public function user() {

        return $this->belongsTo('User', 'user_id');
    }

    public function photo() {
        return $this->hasOne('Photo', 'id', 'photo_id');
    }

    public function posts(){

        return NULL;
    }
}