<?php

return [

    /*
    |--------------------------------------------------------------------------
    | excepted routes (you can use regex to match) will not be traced and
    | saved as logs.
    |--------------------------------------------------------------------------
    |
    */
    'exceptions' => [
        'captcha',
        '.+\/map',
        '.*\/media\/resize\/.+',
    ],

];
