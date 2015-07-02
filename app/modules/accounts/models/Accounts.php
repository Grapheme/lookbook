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

        return $this->hasOne('BloggerMonetization', 'user_id', 'id');
    }

    public function cooperation_brands(){

        return $this->belongsToMany('BloggerCooperationBrands','user_cooperation_brands','user_id', 'cooperation_brand_id');

    }

    public function thrust(){

        return $this->belongsToMany('BloggerThrust','user_thrust', 'user_id', 'thrust_id');
    }

}