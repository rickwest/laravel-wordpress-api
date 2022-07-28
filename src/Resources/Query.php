<?php

namespace RickWest\WordPress\Resources;

use Illuminate\Support\Arr;

class Query
{
    private array $parameters;

    /**
     * Permitted global parameters which control how the API handles the request/response handling.
     * These operate at a layer above the actual resources themselves, and are available on all resources.
     *
     * @var array|string[]
     */
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
