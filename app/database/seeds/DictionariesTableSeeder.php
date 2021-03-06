<?php

class DictionariesTableSeeder extends Seeder {

    public function run(){

        Dictionary::create(array('slug'=>'categories','name'=>'Категории','entity'=> 1,'icon_class'=>'fa-th-large','hide_slug'=>1,'make_slug_from_name'=>NULL,'name_title'=>NULL,'pagination'=>0,'view_access'=>0,'sort_by'=>NULL,'sort_order_reverse'=>0,'sortable'=>1,'order'=>0));
        Dictionary::create(array('slug'=>'tags','name'=>'Теги','entity'=> 1,'icon_class'=>'fa-tags','hide_slug'=>1,'make_slug_from_name'=>NULL,'name_title'=>'Текст','pagination'=>0,'view_access'=>0,'sort_by'=>NULL,'sort_order_reverse'=>0,'sortable'=>1,'order'=>0));
        Dictionary::create(array('slug'=>'cooperation_brands','name'=>'Сотрудничество','entity'=> 1,'icon_class'=>'fa-circle-o','hide_slug'=>1,'make_slug_from_name'=>NULL,'name_title'=>'Текст','pagination'=>0,'view_access'=>0,'sort_by'=>NULL,'sort_order_reverse'=>0,'sortable'=>1,'order'=>0));
        Dictionary::create(array('slug'=>'main_thrust','name'=>'Направленность','entity'=> 1,'icon_class'=>'fa-circle-o','hide_slug'=>1,'make_slug_from_name'=>NULL,'name_title'=>'Текст','pagination'=>0,'view_access'=>0,'sort_by'=>NULL,'sort_order_reverse'=>0,'sortable'=>1,'order'=>0));
    }
}