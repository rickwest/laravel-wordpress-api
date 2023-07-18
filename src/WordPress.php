<?php

namespace RickWest\WordPress;

use RickWest\WordPress\Resources\Categories;
use RickWest\WordPress\Resources\Tags;
use RickWest\WordPress\Resources\Comments;
use RickWest\WordPress\Resources\Media;
use RickWest\WordPress\Resources\Pages;
use RickWest\WordPress\Resources\Posts;
use RickWest\WordPress\Resources\Users;

/**
 * @method Comments comments()
 * @method Categories categories()
 * @method tags tags()
 * @method Media media()
 * @method Pages pages()
 * @method Posts posts()
 * @method Users users()
 */
class WordPress extends BaseWordPress
{
    protected array $resources = [
        'categories' => Categories::class,
        'tags' => Tags::class,
        'comments' => Comments::class,
        'media' => Media::class,
        'pages' => Pages::class,
        'posts' => Posts::class,
        'users' => Users::class,
    ];
}
