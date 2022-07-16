<?php

namespace RickWest\Wordpress;

use InvalidArgumentException;

abstract class BaseWordpress
{
    protected Client $client;

    protected array $resources = [];

    public function __construct(Client $client = null)
    {
        $this->client = $client ?? new Client();
    }

    public function __call($name, $arguments)
    {
        return $this->make($name);
    }

    public function __get($name)
    {
        return $this->make($name);
    }

    private function make($name)
    {
        if (! array_key_exists($name, $this->resources)) {
            throw new InvalidArgumentException("Resource [$name] does not exist.");
        }

        return new $this->resources[$name]($this->client);
    }
}
