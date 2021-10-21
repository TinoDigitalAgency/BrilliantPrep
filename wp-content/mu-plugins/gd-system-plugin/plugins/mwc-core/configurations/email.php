<?php

use GoDaddy\WordPress\MWC\Core\Email\WordPressEmailService;

return [
    'services' => [
        'text/html' => WordPressEmailService::class,
        'text/plain' => WordPressEmailService::class,
    ]
];
