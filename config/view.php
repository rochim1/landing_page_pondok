<?php

return [
    'paths' => [
        resource_path('views'),
    ],

    // Do not use realpath() here. It returns false when the runtime directory
    // has not been created yet and can make Blade fall back to the system temp
    // directory. VIEW_COMPILED_PATH may still override this per environment.
    'compiled' => env(
        'VIEW_COMPILED_PATH',
        storage_path('framework/views')
    ),
];
