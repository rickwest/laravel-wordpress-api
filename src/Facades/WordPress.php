<?php

namespace RickWest\WordPress\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \RickWest\WordPress\WordPress
 * @mixin \RickWest\WordPress\WordPress
 */
class WordPress extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \RickWest\WordPress\WordPress::class;
    }
}
