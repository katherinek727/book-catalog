<?php

return [
    'manageBooks' => [
        'type' => 2,
        'description' => 'Manage books (create, update, delete)',
    ],
    'manageAuthors' => [
        'type' => 2,
        'description' => 'Manage authors (create, update, delete)',
    ],
    'guest' => [
        'type' => 1,
        'description' => 'Guest user (can view, subscribe)',
    ],
    'user' => [
        'type' => 1,
        'description' => 'Authenticated user (can manage books and authors)',
        'children' => [
            'manageBooks',
            'manageAuthors',
        ],
    ],
];
