<?php

use Illuminate\Contracts\Foundation\Application;
use RickWest\Wordpress\SportsPress;
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

if (! function_exists("sportspress")) {

    /**
     * @return Application|mixed|SportsPress
     * @throws Exception
     */
    function sportspress()
    {
        return app(SportsPress::class);
    }
}
