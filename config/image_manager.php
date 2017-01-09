<?php

return [

    /*
    |--------------------------------------------------------------------------
    | ImageManager v.2
    |--------------------------------------------------------------------------
    |
    |
    */

    'origin' => [
        'make' => true,
        'path' => '/uploads/photos/',
    ],

    'original_name' => false,

    'more' => [
        'large' => [
            'make' => false,
            'path' => '/uploads/photos/large/',
            'width' => 1280,
            'height' => 1024,
            'compress' => 60,
            'method' => 'resize',           #fit, resize, resizeCanvas
        ],

        'medium' => [
            'make' => false,
            'path' => '/uploads/photos/medium/',
            'width' => 640,
            'height' => 480,
            'compress' => 60,
            'method' => 'resize',           #fit, resize, resizeCanvas
        ],

        'small' => [
            'make' => false,
            'path' => '/uploads/photos/small/',
            'width' => 250,
            'height' => 180,
            'compress' => 60,
            'method' => 'resize',           #fit, resize, resizeCanvas
        ],
    ],
];