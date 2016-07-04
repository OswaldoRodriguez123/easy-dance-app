<?php

return [


    // 'driver' => env('MAIL_DRIVER', 'smtp'),
    // 'host' => env('MAIL_HOST', 'smtp.gmail.com'),
    // 'port' => env('MAIL_PORT', 587),
    // 'from' => ['address' => 'latinoeasydance@gmail.com', 'name' => 'Easy Dance'],
    // 'encryption' => env('MAIL_ENCRYPTION', 'tls'),
    // 'username' => env('MAIL_USERNAME'),
    // 'password' => env('MAIL_PASSWORD'),
    // 'sendmail' => '/usr/sbin/sendmail -bs',
    // 'pretend' => false,

    // 'driver' => env('MAIL_DRIVER', 'smtp'),
    // 'host' => env('MAIL_HOST', 'smtp.mailgun.org'),
    // 'port' => env('MAIL_PORT', 587),
    // 'username' => env('MAIL_USERNAME'),
    // 'password' => env('MAIL_PASSWORD'),

    'driver'     => 'mailgun',
    'host'       => 'smtp.mailgun.org',
    'port'       =>  587,
    'from' => ['address' => 'latinoeasydance@gmail.com', 'name' => 'Easy Dance'],
    'encryption' => 'tls',
    'username'   => 'postmaster@easydancelatino.com',
    'password'   => '52eb3916c366b58fa92ef62676a639d2',
    'sendmail'   => '/usr/sbin/sendmail -bs',
    'pretend'    => false,


];
