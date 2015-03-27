<?php

return array(

    'fields' => function ($dicval = NULL) {

        $dics_slugs = array('categories','tags');
        $dics = Dic::whereIn('slug', $dics_slugs)->with('values')->get();
        $dics = Dic::modifyKeys($dics, 'slug');
        $lists = Dic::makeLists($dics, 'values', 'name', 'id');
        $lists_ids = Dic::makeLists($dics, null, 'id', 'slug');

        return array(

            'category_id' => array(
                'title' => 'Категория (Раздел)',
                'type' => 'select',
                'values' => $lists['categories'], ## Используется предзагруженный словарь
                'default' => Input::get('filter.fields.category_id') ?: null,
            ),
            'tags_id' => array(
                'title' => 'Теги',
                'type' => 'checkboxes',
                'columns' => 2, ## Количество колонок
                'values' => $lists['tags'],
                'handler' => function ($value, $element) use ($lists_ids) {
                    $value = DicLib::formatDicValRel($value, 'tags_id', $element->dic_id, $lists_ids['tags']);
                    $element->related_dicvals()->sync($value);
                    return @count($value);
                },
                'value_modifier' => function ($value, $element) {
                    $return = (is_object($element) && $element->id)
                        ? $element->related_dicvals()->get()->lists('name', 'id')
                        : $return = array();
                    return $return;
                },
            ),
        );
    },
    'menus' => function($dic, $dicval = NULL) {
        $menus = array();
        $dics_slugs = array('categories');
        $dics = Dic::whereIn('slug', $dics_slugs)->with('values')->get();
        $dics = Dic::modifyKeys($dics, 'slug');
        $lists = Dic::makeLists($dics, 'values', 'name', 'id');
        $menus[] = Helper::getDicValMenuDropdown('category_id', 'Все категории', $lists['categories'], $dic);
        return $menus;
    },
    'actions' => function($dic, $dicval) {

    },
    'hooks' => array(
        'before_all' => function ($dic) {},
        'before_index' => function ($dic) {},
        'before_index_view' => function ($dic, $dicvals) {
            $dics_slugs = array('categories');
            $dics = Dic::whereIn('slug', $dics_slugs)->with('values')->get();
            $dics = Dic::modifyKeys($dics, 'slug');
            $lists = Dic::makeLists($dics, 'values', 'name', 'id');
            Config::set('temp.categories', $lists['categories']);
        },
        'before_create_edit' => function ($dic) {},
        'before_create' => function ($dic) {},
        'before_edit' => function ($dic, $dicval) {},
        'before_store_update' => function ($dic) {},
        'before_store' => function ($dic) {},
        'after_store' => function ($dic, $dicval) {},
        'before_update' => function ($dic, $dicval) {},
        'after_update' => function ($dic, $dicval) {},
        'before_destroy' => function ($dic, $dicval) {},
        'after_destroy' => function ($dic, $dicval) {},
    ),

    'second_line_modifier' => function($line, $dic, $dicval) {
        $dicval->extract(1);
        $categories = Config::get('temp.categories');
        return 'Категория (Раздел): '.@$categories[$dicval['category_id']];
    },

    'seo' => false,
    'versions' => 0,
);