<?php

namespace RickWest\WordPress;

use InvalidArgumentException;
use RickWest\WordPress\Resources\Resource;

abstract class BaseWordPress
{
    protected Client $client;

    /**
     * @var array<string, class-string<Resource>>
     */
    protected array $resources = [];

    public function __construct(Client $client = null)
    {
        $this->client = $client ?? new Client();
    }

    public function __call(string $name, array $arguments): Resource
    {
        return $this->make($name);
    }

    public function __get(string $name): Resource
    {
        return $this->make($name);
    }

    private function make(string $name): Resource
    {
        if (! array_key_exists($name, $this->resources)) {
            throw new InvalidArgumentException("Resource [$name] does not exist.");
        }

        return new $this->resources[$name]($this->client);
    }
}
