<?php

namespace RickWest\Wordpress\Resources\Traits;

use Carbon\CarbonInterface;

trait HasDate
{
    /**
     * Limit response to resources published after a given ISO8601 compliant date.
     *
     * @param CarbonInterface $date
     * @return static
     */
    public function after(CarbonInterface $date): static
    {
        return $this->parameter('after', $date->toIso8601String());
    }

    /**
     * Limit response to posts published after a given ISO8601 compliant date.
     *
     * @param CarbonInterface $date
     * @return static
     */
    public function before(CarbonInterface $date): static
    {
        return $this->parameter('before', $date->toIso8601String());
    }

    public function latest(string $field = 'date'): static
    {
        return $this->orderBy($field);
    }

    public function oldest(string $field = 'date'): static
    {
        return $this->orderBy($field, 'asc');
    }
}
