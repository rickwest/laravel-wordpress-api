<?php

namespace RickWest\WordPress\Resources\Traits;

trait HasAuthor
{
    /**
     * Limit result set to resources assigned to specific authors.
     *
     * @param int|int[] $ids
     * @return $this
     */
    public function author(int|array $ids): static
    {
        return $this->parameter('author', $ids);
    }

    /**
     * Ensure result set excludes resources assigned to specific authors.
     *
     * @param int|int[] $ids
     * @return $this
     */
    public function authorExclude(int|array $ids): static
    {
        return $this->parameter('author_exclude', $ids);
    }
}
