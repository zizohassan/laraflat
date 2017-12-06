<?php

define('DS', DIRECTORY_SEPARATOR);

if (! function_exists('app_path')) {
    /**
     * Get the path to the application folder.
     *
     * @param  string  $path
     * @return string
     */
    function app_path($path = '')
    {
        return app('path').($path ? DS.path($path) : path($path));
    }
}


if (! function_exists('path')) {
    /**
     * Get the path to the application folder.
     *
     * @param  string  $path
     * @return string
     */
    function path($path)
    {
        return str_replace(['/' , '\\'] , DS , $path);
    }
}
