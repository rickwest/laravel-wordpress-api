<?php

namespace RickWest\Wordpress\Resources;

class Query
{
    private array $globalParameters;

    private array $parameters;

    public function __construct()
    {
        $this->globalParameters = [];
        $this->parameters = [];
    }

    /**
     * @param $key
     * @param $value
     * @return $this
     */
    public function globalParameter($key, $value): static
    {
        $this->globalParameters[$key] = $value;

        return $this;
    }

    /**
     * @param $key
     * @param $value
     * @return $this
     */
    public function parameter($key, $value): static
    {
        $this->parameters[$key] = $value;

        return $this;
    }

    /**
     * @return array
     */
    public function globalParameters(): array
    {
        return $this->globalParameters;
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
    public function all(): array
    {
        return array_merge($this->globalParameters(), $this->parameters());
    }
}
