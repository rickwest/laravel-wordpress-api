<?php

use Illuminate\Contracts\Foundation\Application;
use RickWest\Wordpress\Wordpress;

if (! function_exists("wordpress")) {

    /**
     * @return Application|mixed|Wordpress
     */
    function wordpress()
    {
        return app(Wordpress::class);
    }
}
