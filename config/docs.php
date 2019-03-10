<?php

return [
    // version 표기는 string 형태로 해야함.
    'versions' => [
        '5.0' => [
            'deprecatedAt' => '2016-02-04',
            'lts' => false,
        ],
        '5.1' => [
            'deprecatedAt' => '2018-06-09',
            'lts' => true,
        ],
        '5.2' => [
            'deprecatedAt' => '2016-12-21',
            'lts' => false,
        ],
        '5.3' => [
            'deprecatedAt' => '2017-08-23',
            'lts' => false,
        ],
        '5.4' => [
            'deprecatedAt' => '2018-01-24',
            'lts' => false,
        ],
        '5.5' => [
            'deprecatedAt' => '2020-08-30',
            'lts' => true,
        ],
        '5.6' => [
            'deprecatedAt' => '2019-02-07',
            'lts' => false,
        ],
        '5.7' => [
            'deprecatedAt' => '2019-09-04',
            'lts' => false,
        ],
    ],
    'default' => '5.7',
    'resource_root' => 'documents',
    'basePath' => 'baseGit',

];
