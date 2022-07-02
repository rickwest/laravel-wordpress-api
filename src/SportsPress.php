<?php

namespace RickWest\Wordpress;

use RickWest\Wordpress\Resources\SportsPress\Calendars;
use RickWest\Wordpress\Resources\SportsPress\Events;
use RickWest\Wordpress\Resources\SportsPress\Leagues;
use RickWest\Wordpress\Resources\SportsPress\Players;
use RickWest\Wordpress\Resources\SportsPress\Positions;
use RickWest\Wordpress\Resources\SportsPress\Roles;
use RickWest\Wordpress\Resources\SportsPress\Seasons;
use RickWest\Wordpress\Resources\SportsPress\Staff;
use RickWest\Wordpress\Resources\SportsPress\Teams;
use RickWest\Wordpress\Resources\SportsPress\Venues;

/**
 * @method Calendars calendars()
 * @method Events events()
 * @method Leagues leagues()
 * @method Players players()
 * @method Positions positions()
 * @method Roles roles()
 * @method Seasons seasons()
 * @method Staff staff()
 * @method Teams teams()
 * @method Venues venues()
 */
class SportsPress extends BaseWordpress
{
    protected array $resources = [
        'calendars' => Calendars::class,
        'events' => Events::class,
        'leagues' => Leagues::class,
        'players' => Players::class,
        'positions' => Positions::class,
        'roles' => Roles::class,
        'seasons' => Seasons::class,
        'staff' => Staff::class,
        'teams' => Teams::class,
        'venues' => Venues::class,
    ];
}
