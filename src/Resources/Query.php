<?php

namespace RickWest\Wordpress\Resources;

use Illuminate\Support\Arr;

class Query
{
    private array $parameters;

    private array $global = ['_fields', '_embed', '_method', '_envelope'];

    public function __construct()
    {
        $this->parameters = [];
    }

    /**
     * @param string $key
     * @param mixed $value
     * @return $this
     */
    public function parameter(string $key, mixed $value): static
    {
        $this->parameters[$key] = $value;

        return $this;
    }

    /**
     * @return array
     */
    public function parameters(): array
    {
        return $this->parameters;
    }

    /**
     * @return array
     */
    public function globalParameters(): array
    {
        return Arr::only($this->parameters, $this->global);
    }
}
