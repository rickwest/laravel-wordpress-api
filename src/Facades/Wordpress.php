<?php

namespace RickWest\Wordpress\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \RickWest\Wordpress\Wordpress
 * @mixin \RickWest\Wordpress\Wordpress
 */
class Wordpress extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \RickWest\Wordpress\Wordpress::class;
    }
}
