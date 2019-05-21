<?php
return [
    'settings' => [
        'determineRouteBeforeAppMiddleware' => false,
        'displayErrorDetails'               => (bool)getenv('DISPLAY_ERRORS'), // set to false in production
        'addContentLengthHeader'            => false, // Allow the web server to send the content-length header

        // Renderer settings
        'renderer'                          => [
            'template_path' => __DIR__ . '/../templates/',
        ],

        // View settings
        'view'                              => [
            'template_path' => __DIR__ . '/../templates/',
            'twig'          => [
                'cache'       => __DIR__ . '/../cache/templates/',
                'debug'       => true,
                'auto_reload' => true,
            ],
        ],

        // DB
        'db'                                => [
            'driver'    => parse_url(getenv('DATABASE_URL'), PHP_URL_SCHEME),
            'host'      => parse_url(getenv('DATABASE_URL'), PHP_URL_HOST),
            'database'  => substr(parse_url(getenv('DATABASE_URL'), PHP_URL_PATH), 1),
            'username'  => parse_url(getenv('DATABASE_URL'), PHP_URL_USER),
            'password'  => parse_url(getenv('DATABASE_URL'), PHP_URL_PASS),
            'charset'   => 'utf8mb4',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => '',
            'timezone'  => '-09:00'
        ],

        // Monolog settings
        'logger'                            => [
            'name'  => 'slim-app',
            'path'  => isset($_ENV['docker']) ? 'php://stdout' : __DIR__ . '/../logs/app.log',
            'level' => (bool)getenv('DEBUG') ? \Monolog\Logger::DEBUG : \Monolog\Logger::ERROR,
        ],
    ],
];
