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
     * @param string $key
     * @param mixed $value
     * @return $this
     */
    public function globalParameter(string $key, mixed $value): static
    {
        $this->globalParameters[$key] = $value;

        return $this;
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
