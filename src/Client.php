<?php

namespace RickWest\Wordpress;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

class Client
{
    private string $baseUrl;

    public function __construct(string $baseUrl)
    {
        $this->baseUrl = $baseUrl;
    }

    /**
     * @param string $method
     * @param string $endpoint
     * @param array $parameters
     * @return Response
     */
    public function send(string $method, string $endpoint, array $parameters = []): Response
    {
        return Http::send($method, $this->baseUrl.$endpoint, $parameters);
    }
}
