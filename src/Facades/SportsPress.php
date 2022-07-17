<?php

namespace RickWest\Wordpress\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \RickWest\Wordpress\SportsPress
 * @mixin \RickWest\Wordpress\SportsPress
 */
class SportsPress extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'sportspress';
    }
}
