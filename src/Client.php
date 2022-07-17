<?php

namespace RickWest\Wordpress;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

class Client
{
    private string $baseUrl;

    public function __construct(string $baseUrl = null)
    {
        $this->baseUrl = $baseUrl ?? strval(config('wordpress-api.url'));
    }

    /**
     * @param string $method
     * @param string $endpoint
     * @param array $options
     * @return Response
     */
    public function send(string $method, string $endpoint, array $options = []): Response
    {
        return Http::send($method, $this->baseUrl.$endpoint, $options);
    }
}
