<?php

/*
 * This file is part of the seaony/wangeditor.
 *
 * (c) seaony <seaony@seaony.cn>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

return [

    // File upload route
    'route' => [
        'url' => '/wangeditor/server',
        'options' => [
            // middleware => 'auth',
        ],
    ],

    // File save path
    'upload' => [
        'path' => 'uploads/images',
        'disk' => 'public'
    ],


    'uploadImgMaxLength' => 5
];
