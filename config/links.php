<?php
return [
    /* Middleware that will be applied to the statistic pages */
    'middleware' => \App\Http\Middleware\AdminMiddleware::class,

    /* Password to use if ConsoleTVs\Links\Middleware\LinksMiddleware is beeing used */
    'password' => 'LinksRocks',

    /* The views layout */
    'layout' => layoutPath('layout.apps'),


    /* The route prefix, will be applied to all of the routes. */
    'prefix' => '/admin/links',
];
