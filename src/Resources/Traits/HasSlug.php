<?php

namespace RickWest\WordPress\Resources\Traits;

trait HasSlug
{
    /**
     * Limit result set to resources with one or more specific slugs.
     *
     * @param string $slug
     * @return $this
     */
    public function slug(string $slug): static
    {
        return $this->parameter('slug', $slug);
    }
}
