<?php
return [
    'guards' => [
        'blog_user' => [
            'driver' => 'session',
            'provider' => 'blog_user',
        ]
    ],
    'providers' => [
        'blog_user' => [
            'driver' => 'eloquent',
            'model' => \Plugin\Package\Blog\Models\User::class,
        ],
    ]
];