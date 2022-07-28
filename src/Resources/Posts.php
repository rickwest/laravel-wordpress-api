<?php

namespace RickWest\WordPress\Resources;

use RickWest\WordPress\Resources\Traits\HasAuthor;
use RickWest\WordPress\Resources\Traits\HasDate;
use RickWest\WordPress\Resources\Traits\HasSlug;

class Posts extends Resource
{
    use HasSlug;
    use HasDate;
    use HasAuthor;
}
