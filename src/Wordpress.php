<?php

namespace RickWest\Wordpress;

use RickWest\Wordpress\Resources\Categories;
use RickWest\Wordpress\Resources\Comments;
use RickWest\Wordpress\Resources\Media;
use RickWest\Wordpress\Resources\Pages;
use RickWest\Wordpress\Resources\Posts;
use RickWest\Wordpress\Resources\Users;

/**
 * @method Comments comments()
 * @method Categories categories()
 * @method Media media()
 * @method Pages pages()
 * @method Posts posts()
 * @method Users users()
 */
class Wordpress extends BaseWordpress
{
    protected array $resources = [
        'categories' => Categories::class,
        'comments' => Comments::class,
        'media' => Media::class,
        'pages' => Pages::class,
        'posts' => Posts::class,
        'users' => Users::class,
    ];
}
