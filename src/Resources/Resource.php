<?php

namespace RickWest\Wordpress\Resources;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Str;
use RickWest\Wordpress\Client;

abstract class Resource
{
    protected Client $client;

    protected Query $query;

    protected string $wrap = 'data';

    public function __construct(Client $client)
    {
        $this->client = $client;
        $this->query = new Query();
    }

    /**
     * Send a request to the resource endpoint.
     *
     * @param string $method
     * @param int|null $id
     * @param array $options
     * @return Response
     */
    public function send(string $method, int $id = null, array $options = []): Response
    {
        return $this->client->send($method, $this->endpoint().($id ? '/'.$id : ''), $options);
    }

    /**
     * Retrieve a specific resource by ID.
     *
     * @param int $id
     * @param array $parameters
     * @return array|null
     */
    public function find(int $id, array $parameters = []): ?array
    {
        $response = $this->send('GET', $id, ['query' => array_merge($this->query->globalParameters(), $parameters)]);

        return $response->successful() ? (array) $response->json() : null;
    }

    /**
     * Retrieve a collection of resources.
     *
     * @param array|string|null $fields Specify a subset of fields to return, in the response.
     * @return array
     */
    public function get(array|string $fields = null): array
    {
        if ($fields) {
            $this->fields($fields);
        }

        return $this->listResponse(
            $this->send('GET', null, ['query' => $this->query->parameters()])
        );
    }

    /**
     * Format a list response, adding pagination information.
     *
     * @param Response $response
     * @return array
     */
    private function listResponse(Response $response): array
    {
        $successful = $response->successful();

        return [
            $this->wrap => $successful ? $response->json() : [],
            'meta' => [
                'pages' => $successful ? (int) $response->header('X-WP-TotalPages') : 0,
                'total' => $successful ? (int) $response->header('X-WP-Total') : 0,
            ],
        ];
    }

    /**
     * Add a parameter to the query.
     *
     * @param string $key
     * @param mixed $value
     * @return $this
     */
    public function parameter(string $key, mixed $value): static
    {
        $this->query->parameter($key, $value);

        return $this;
    }

    /**
     * Embed related resources.
     * Can optionally be passed a single/array of specific resources to embed.
     *
     * @see https://developer.wordpress.org/rest-api/using-the-rest-api/linking-and-embedding/
     *
     * @param string|string[]|null $relations
     * @return $this
     */
    public function embed(string|array $relations = null): static
    {
        $this->parameter('_embed', $relations ?: '1');

        return $this;
    }

    /**
     * More expressive alias for embed.
     *
     * @param string|string[] $relations
     * @return $this
     */
    public function with(string|array $relations): static
    {
        return $this->embed($relations);
    }

    /**
     * Specify a subset of fields to return, in the response.
     *
     * @see https://developer.wordpress.org/rest-api/using-the-rest-api/global-parameters/#_fields
     *
     * @param array|string $fields
     * @return $this
     */
    public function fields(array|string $fields): static
    {
        $this->parameter('_fields', $fields);

        return $this;
    }

    /**
     * The page of results to return.
     *
     * @param int $page
     * @return $this
     */
    public function page(int $page): static
    {
        return $this->parameter('page', $page);
    }

    /**
     * The number of records to return in one request.
     *
     * @param int $perPage 1 - 100
     * @return $this
     */
    public function perPage(int $perPage): static
    {
        return $this->parameter('per_page', $perPage);
    }

    /**
     * An arbitrary offset at which to start retrieving posts.
     *
     * @param int $offset
     * @return $this
     */
    public function offset(int $offset): static
    {
        return $this->parameter('offset', $offset);
    }

    /**
     * Limit results to those matching a string.
     *
     * @param string $term
     * @return $this
     */
    public function search(string $term): static
    {
        return $this->parameter('search', $term);
    }

    /**
     * Ensure result set excludes specific IDs.
     *
     * @param int|int[] $ids
     * @return $this
     */
    public function exclude(int|array $ids): static
    {
        return $this->parameter('exclude', $ids);
    }

    /**
     * Limit result set to specific IDs
     *
     * @param int|int[] $ids
     * @return $this
     */
    public function include(int|array $ids): static
    {
        return $this->parameter('include', $ids);
    }

    /**
     * Sort collection by object attribute, either ascending or descending.
     *
     * @param string $field
     * @param string $direction
     * @return $this
     */
    public function orderBy(string $field, string $direction = 'desc'): static
    {
        return $this->parameter('orderby', $field)
            ->parameter('order', $direction);
    }

    /**
     * Conditionally add a parameter to the query.
     *
     * @param mixed $value
     * @param callable $callback
     * @return $this
     */
    public function when(mixed $value, callable $callback): static
    {
        if ($value) {
            $callback($this, $value);
        }

        return $this;
    }

    /**
     * @return string
     */
    protected function name(): string
    {
        return Str::lower(
            (new \ReflectionClass($this))->getShortName()
        );
    }

    /**
     * @return string
     */
    protected function endpoint(): string
    {
        return '/wp-json/wp/v2/'.$this->name();
    }
}
