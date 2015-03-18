<?php

class AccountsSocialController extends BaseController {

    public static $name = 'social';
    public static $group = 'accounts';
    public static $entity = 'social';
    public static $entity_name = 'Работа с социальными сетями';

    /****************************************************************************/

    public static function returnRoutes($prefix = null) {
        $class = __CLASS__;
        Route::get('signin/social/facebook', array('as' => 'signin-facebook', 'uses' => $class . '@SigninFacebook'));
    }

    public static function returnShortCodes() {
        return NULL;
    }

    public static function returnActions() {
        return NULL;
    }

    public static function returnInfo() {
        return NULL;
    }

    public static function returnMenu() {
        return NULL;
    }

    /****************************************************************************/

    public function __construct(){

        $this->module = array(
            'name' => self::$name,
            'group' => self::$group,
            'rest' => self::$group,
            'tpl' => static::returnTpl(),
            'gtpl' => static::returnTpl(),
            'class' => __CLASS__,

            'entity' => self::$entity,
            'entity_name' => self::$entity_name,
        );
        View::share('module', $this->module);
    }

    /****************************************************************************/
    public function SigninFacebook(){


    }
    /****************************************************************************/
}