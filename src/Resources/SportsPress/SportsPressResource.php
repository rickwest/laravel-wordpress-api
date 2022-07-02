<?php

namespace RickWest\Wordpress\Resources\SportsPress;

use RickWest\Wordpress\Resources\Resource;
use RickWest\Wordpress\Resources\Traits\HasSlug;

abstract class SportsPressResource extends Resource
{
    use HasSlug;

    /**
     * @inheritDoc
     */
    protected function endpoint(): string
    {
        return '/wp-json/sportspress/v2/'.$this->name();
    }
}
