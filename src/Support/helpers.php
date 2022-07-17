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
        if (! config('wordpress-api.sportspress.enabled')) {
            throw new Exception("Target class [".SportsPress::class."] does not exist. Enable is, by setting environment variable 'SPORTSPRESS_ENABLED' to true");
        }

        return app(SportsPress::class);
    }
}
