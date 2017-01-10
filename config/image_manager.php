<?php

return [

    /*
    |--------------------------------------------------------------------------
    | ImageManager v.2.0.1
    |--------------------------------------------------------------------------
    |
    |
    */

    'origin' => [
        'make' => true,
        'path' => '/uploads/img/',
    ],

    'original_name' => false,

    'more' => [
        'large' => [
            'make' => false,
            'path' => '/large/',
            'width' => 1280,
            'height' => 1024,
            'compress' => 60,
            'method' => 'resize',           #fit, resize, resizeCanvas
        ],

        'medium' => [
            'make' => false,
            'path' => '/medium/',
            'width' => 640,
            'height' => 480,
            'compress' => 60,
            'method' => 'resize',           #fit, resize, resizeCanvas
        ],

        'small' => [
            'make' => false,
            'path' => '/small/',
            'width' => 250,
            'height' => 180,
            'compress' => 60,
            'method' => 'resize',           #fit, resize, resizeCanvas
        ],
    ],
];