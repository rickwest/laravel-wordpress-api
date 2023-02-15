<?php

use Illuminate\Contracts\Foundation\Application;
use RickWest\WordPress\WordPress;

if (! function_exists("wordpress")) {
    /**
     * @return Application|mixed|WordPress
     */
    function wordpress()
    {
        return app(WordPress::class);
    }
}
