<?php

namespace RickWest\Wordpress\Resources\Traits;

trait HasSlug
{
    public function slug(string $slug): static
    {
        return $this->parameter('slug', $slug);
    }
}
