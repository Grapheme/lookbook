<?php

return array(

    'feedback' => array(
        'address' => 'support@look-book.ru',
    ),

    'driver' => 'smtp',
    'host' => 'in.mailjet.com',
    'port' => 587,
    'from' => array(
        'address' => 'support@look-book.ru',
        #'address' => 'support@grapheme.ru',
        'name' => 'LOOKBOOK'
    ),
    'username' => '0d8dd8623bd38b41c43683c41c0558eb',
    'password' => '465c500abd5f680f0b20405deb967b36',

    'sendmail' => '/usr/sbin/sendmail -bs',
    'encryption' => 'tls',

    'pretend' => 0,
);