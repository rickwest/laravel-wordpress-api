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

    public function __construct($client)
    {
        $this->client = $client;
        $this->query = new Query();
    }

    /**
     * @param $key
     * @param $value
     * @return $this
     */
    public function globalParameter($key, $value): static
    {
        $this->query->globalParameter($key, $value);

        return $this;
    }

    /**
     * @param $key
     * @param $value
     * @return $this
     */
    public function parameter($key, $value): static
    {
        $this->query->parameter($key, $value);

        return $this;
    }

    /**
     * @param string|string[]|null $relations
     * @return $this
     */
    public function embed(string|array $relations = null): static
    {
        $this->globalParameter('_embed', $relations ?: '1');

        return $this;
    }

    /**
     * @param string|string[] $relations
     * @return $this
     */
    public function with(string|array $relations): static
    {
        return $this->embed($relations);
    }

    /**
     * @param array|string $fields
     * @return $this
     */
    public function fields(array|string $fields): static
    {
        $this->globalParameter('_fields', is_string($fields) ? [$fields] : $fields);

        return $this;
    }

    /**
     * @param int $id Unique identifier for the resource.
     * @param array $parameters
     * @return array|null
     */
    public function find(int $id, array $parameters = []): ?array
    {
        $response = $this->send('GET', $id, ['query' => array_merge($this->query->globalParameters(), $parameters)]);

        return $response->successful() ? $response->json() : null;
    }

    /**
     * @param array|string|null $fields
     * @return array
     */
    public function get(array|string $fields = null): array
    {
        if ($fields) {
            $this->fields($fields);
        }

        return $this->listResponse(
            $this->send('GET', null, ['query' => $this->query->all()])
        );
    }

    /**
     * @param Response $response
     * @return array
     */
    private function listResponse(Response $response): array
    {
        $successful = $response->successful();

        return [
            $this->wrap => $successful ? $response->collect() : collect([]),
            'meta' => [
                'pages' => $successful ? (int) $response->header('X-WP-TotalPages') : 0,
                'total' => $successful ? (int) $response->header('X-WP-Total') : 0,
            ],
        ];
    }

    /**
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
