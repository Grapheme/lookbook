<?php

return array(

    'theme_path' => 'theme',

    'paginate_limit' => 30,

    ## Disable functionality of changing url "on-the-fly" for generating
    ## seo-friendly url (via URL::route('page', '...')) with right various url-segments for multilingual pages.
    'disable_url_modification' => 0,

    'uploads_dir' => public_path('uploads/files'),
    'uploads_user_dir' => public_path('uploads/users'),
    'uploads_file_user_dir' => 'uploads/users',
    'uploads_image_user_dir' => 'uploads/users',
    'uploads_thumb_user_dir' => 'uploads/users/thumbnail',

    'uploads_photo_dir' => public_path('uploads'),
    'uploads_thumb_dir' => public_path('uploads/thumbs'),
    'uploads_photo_public_dir' => '/uploads',
    'uploads_thumb_public_dir' => '/uploads/thumbs',

    'galleries_photo_dir'        => public_path('uploads/galleries'),
    'galleries_photo_public_dir' => '/uploads/galleries',
    'galleries_thumb_dir'        => public_path('uploads/galleries/thumbs'),
    'galleries_thumb_public_dir' => '/uploads/galleries/thumbs',

    'galleries_photo_size'       => -800, # 800 => 800x600 || 600x800 ; -800 => 800x1000 || 1000x800
    'galleries_thumb_size'       => -200, # 200 => 200x150 || 150x200 ; -200 => 200x300 || 300x200

    'galleries_cache_dir'        => public_path('uploads/galleries/cache'),
    'galleries_cache_public_dir' => '/uploads/galleries/cache',
    'galleries_cache_allowed_sizes' => [
        '200x200'
    ],

    'seo' => [
        'default_title'       => 'LookBook',
        'default_description' => '',
        'default_keywords'    => '',
    ],

    'dics' => [
        'preload_cache_lifetime' => 60*24, ## время жизни кеша страниц, в минутах
    ],
);
