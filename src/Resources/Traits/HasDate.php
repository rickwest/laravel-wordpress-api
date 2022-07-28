<?php

namespace RickWest\WordPress\Resources\Traits;

use Carbon\CarbonInterface;

trait HasDate
{
    /**
     * Limit response to resources published after a given ISO8601 compliant date.
     *
     * @param CarbonInterface $date
     * @return $this
     */
    public function after(CarbonInterface $date): static
    {
        return $this->parameter('after', $date->toIso8601String());
    }

    /**
     * Limit response to resources published before a given ISO8601 compliant date.
     *
     * @param CarbonInterface $date
     * @return $this
     */
    public function before(CarbonInterface $date): static
    {
        return $this->parameter('before', $date->toIso8601String());
    }

    /**
     * Order results set by date, descending.
     *
     * @param string $field
     * @return $this
     */
    public function latest(string $field = 'date'): static
    {
        return $this->orderBy($field);
    }

    /**
     * Order results set by date, ascending.
     *
     * @param string $field
     * @return $this
     */
    public function oldest(string $field = 'date'): static
    {
        return $this->orderBy($field, 'asc');
    }
}
